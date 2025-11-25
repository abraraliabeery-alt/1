<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportProductsConfig extends Command
{
    protected $signature = 'products:import-config {path : Path to TXT/CSV/XLSX file} {--column=1 : Column number for names (1-based, for CSV/XLSX)}';
    protected $description = 'Import product names into config/products.php from TXT/CSV/XLSX';

    public function handle(): int
    {
        $path = (string)$this->argument('path');
        $column = (int)$this->option('column');
        if (!is_file($path)) {
            $this->error('File not found: '.$path);
            return self::FAILURE;
        }
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $names = $this->parseNames($path, $ext, $column);
        if (empty($names)) {
            $this->error('No valid names found.');
            return self::FAILURE;
        }
        // Build PHP config array content
        $itemsExport = var_export($names, true);
        $php = "<?php\n\nreturn [\n    'items' => {$itemsExport},\n];\n";
        $out = base_path('config/products.php');
        file_put_contents($out, $php);
        $this->info('Wrote '.count($names).' items to config/products.php');
        $this->warn('Run: php artisan config:clear');
        return self::SUCCESS;
    }

    protected function parseNames(string $path, string $ext, int $column = 1): array
    {
        $colIndex = max(1, $column) - 1;
        $names = [];
        try {
            if (in_array($ext, ['txt'])) {
                $content = file_get_contents($path);
                $lines = preg_split("/\r\n|\r|\n/", (string)$content);
                $names = array_map('trim', $lines);
            } elseif (in_array($ext, ['csv'])) {
                if (($handle = fopen($path, 'r')) !== false) {
                    while (($row = fgetcsv($handle)) !== false) {
                        $val = trim((string)($row[$colIndex] ?? ''));
                        if ($val !== '') { $names[] = $val; }
                    }
                    fclose($handle);
                }
            } elseif (in_array($ext, ['xlsx','xls'])) {
                if (!class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory')) {
                    $this->warn('PhpSpreadsheet not installed. Install: composer require phpoffice/phpspreadsheet');
                    return [];
                }
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($path);
                $sheet = $spreadsheet->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
                for ($r = 1; $r <= $highestRow; $r++) {
                    $coord = $colLetter . $r;
                    $cell = $sheet->getCell($coord);
                    $val = trim((string)($cell ? $cell->getValue() : ''));
                    if ($val !== '') { $names[] = $val; }
                }
            }
        } catch (\Throwable $e) {
            $this->error('Parse error: '.$e->getMessage());
            return [];
        }
        // Normalize
        $names = array_values(array_filter($names, fn($v)=>$v!==''));
        if ($names && in_array(mb_strtolower($names[0]), ['الاسم','name'])) {
            array_shift($names);
        }
        $names = array_map(fn($v)=> mb_substr(trim($v), 0, 160), $names);
        $names = array_values(array_unique($names));
        return $names;
    }
}
