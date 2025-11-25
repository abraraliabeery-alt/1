<?php
// Find image URL for each homepage product name using elburoj_images_mapped.csv and validate URLs.
// Prints a PHP array mapping for direct paste into landing.blade.php $imgMap.

mb_internal_encoding('UTF-8');

$names = [
  'توصيلة لي زينة 8مل',
  'دايمر 1000واط اسود بيانو لوكسفاي',
  'فيش 13A مفرد اسود بيانو لوكسفاي',
  'مفتاح ديمر 1000واط بيانو AULMO PLUS',
  'فيش مع مفتاح 13A اسود بيانو AULMO PLUS',
  'ليد ثقة 16واط IP65',
  'كشاف 1000 واط HI PLUS ابيض',
  'U bolt',
  'كوع زاوية مجاري 160مم نيبرو بلاست',
  'قلاب رمل كبير',
  'سدة كاب 110 خفيف بحريني',
  'ماسورة 2بوصة بحريني ضغط 40 ابيض',
  'Wire nut 4mm',
  'قفيز لي 1 بوصة 32مم',
  'مغسلة تعليق ابيض C03 TAK',
  'قسام واي مجاري 110 نيبروبلاست',
  'صفاية بلاط 20*20 ايطالي Schlocer',
  'اتوماتيك بوغاتي',
  'كرسي  RG  كبير',
  'قفيز ربر 1 بوصة',
  'قفيز ربر 1*1/4',
  'قفيز ربر 2 بوصة',
  'قفيز ربر 3 بوصة',
  'قفيز ربر 110مم',
  'قسام مجاري 110*50مم نيبروبلاست',
  'قسام مجاري 110*75مم نيبروبلاست',
  'قسام مجاري 75مم نيبروبلاست',
  'قسام مجاري نيبرو بلاست 110مم',
  'سدة كاب رمادي 160 كلاس 5',
  'سدة كاب رمادي 75مم',
];

$csv = __DIR__ . '/../elburoj_images_mapped.csv';
if (!is_file($csv)) { fwrite(STDERR, "CSV not found: $csv\n"); exit(2); }

$rows = [];
if (($fh = fopen($csv, 'r')) !== false) {
  $h = fgetcsv($fh);
  while (($r = fgetcsv($fh)) !== false) {
    // columns: name,image,url,title
    if (count($r) < 2) continue;
    $n = trim((string)$r[0]);
    $img = trim((string)$r[1]);
    $title = isset($r[3]) ? trim((string)$r[3]) : '';
    if ($n !== '' && $img !== '') { $rows[] = [$n, $img, $title]; }
  }
  // token-overlap fallback with constraints
  if (!$found) {
    $nameT = tokens($name);
    if (!empty($nameT)) {
      // numeric tokens from name must appear in title tokens
      $nameNums = array_values(array_filter($nameT, fn($t)=>preg_match('~^\d|\d$~u',$t)));
      $best = [0.0, null];
      foreach ($index as $k => $imgs) {
        $titleT = tokens($k);
        if (empty($titleT)) continue;
        // numeric constraint
        $hasAllNums = true;
        foreach ($nameNums as $n) { if (!in_array($n, $titleT, true)) { $hasAllNums = false; break; } }
        if (!$hasAllNums && !empty($nameNums)) continue;
        // Jaccard similarity
        $inter = array_values(array_intersect($nameT, $titleT));
        $union = array_values(array_unique(array_merge($nameT, $titleT)));
        $j = (count($union) > 0) ? (count($inter)/count($union)) : 0;
        if ($j >= 0.5) {
          foreach (array_unique($imgs) as $u) {
            if (!valid_url($u) || isset($used[$u])) continue;
            if ($j > $best[0]) { $best = [$j, $u]; }
          }
        }
      }
      if ($best[1]) { $found = $best[1]; }
    }
  }
  fclose($fh);
}

function normalize($s){
  $s = preg_replace('~\s+~u', ' ', (string)$s);
  return trim(mb_strtolower($s ?? '', 'UTF-8'));
}

function tokens($s){
  $s = normalize($s);
  // split on spaces and punctuation, keep numbers and arabic/latin words length >= 2
  $parts = preg_split('~[^\p{L}\p{N}\*\-\+]+~u', $s, -1, PREG_SPLIT_NO_EMPTY);
  $out = [];
  foreach ($parts as $p) {
    $p = trim($p);
    if ($p === '' || mb_strlen($p,'UTF-8') < 2) continue;
    $out[$p] = true;
  }
  return array_keys($out);
}

function valid_url($u): bool {
  if (!preg_match('~^https?://~i', $u)) return false;
  $host = parse_url($u, PHP_URL_HOST);
  if (!$host) return false;
  // whitelist likely hosts
  $okHost = (
    str_ends_with($host, 'cdn.salla.sa') ||
    $host === 'upload.wikimedia.org' ||
    str_ends_with($host, 'elburoj.com')
  );
  if (!$okHost) return false;
  $ch = curl_init($u);
  curl_setopt_array($ch, [
    CURLOPT_NOBODY => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 15,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) PHP-cURL',
  ]);
  curl_exec($ch);
  $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return $code >= 200 && $code < 400;
}

$index = [];
foreach ($rows as [$n,$img,$title]) {
  $index[normalize($n)][] = $img;
  if ($title !== '') { $index[normalize($title)][] = $img; }
}

$map = [];
$used = [];
foreach ($names as $name) {
  $key = normalize($name);
  $found = null;
  // exact normalized name only
  if (isset($index[$key])) {
    foreach (array_unique($index[$key]) as $u) {
      if (!valid_url($u)) continue;
      if (isset($used[$u])) continue; // enforce unique URL across names
      $found = $u; break;
    }
  }
  // Wikimedia/manual fallbacks for known items
  if (!$found) {
    if (stripos($name, 'Wire nut') !== false) $found = 'https://upload.wikimedia.org/wikipedia/commons/f/f0/Wire_nuts.jpg';
    elseif (stripos($name, 'U bolt') !== false) $found = 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b4/BOLT_SCREW_UBT_198.JPG/640px-BOLT_SCREW_UBT_198.JPG';
    elseif (mb_strpos($name, 'قفيز لي 1 بوصة') !== false) $found = 'https://upload.wikimedia.org/wikipedia/commons/5/5a/Two_spring_Hose_Clamps_-_small.jpg';
  }
  if ($found && valid_url($found) && !isset($used[$found])) { $map[$name] = $found; $used[$found] = true; }
}

// Print array literal for Blade $imgMap
echo "\nSuggested \$imgMap entries (paste into landing.blade.php):\n\n";
foreach ($map as $k=>$v) {
  echo "  '" . $k . "' => '" . $v . "',\n";
}

echo "\nResolved " . count($map) . " of " . count($names) . " names.\n";
