<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>مقارنة القالب مع المرجع</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html,body{height:100%}
    iframe{width:100%; height: calc(100vh - 80px); border:1px solid #e5e7eb; border-radius: 8px}
  </style>
</head>
<body class="font-sans" style="font-family:'Cairo',system-ui">
  <div class="p-4">
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-xl font-bold">مقارنة القالب مع المرجع</h1>
      <div class="space-x-2 space-x-reverse">
        <a target="_blank" href="{{ $referenceUrl }}" class="bg-gray-100 px-3 py-2 rounded border">فتح المرجع</a>
        <a target="_blank" href="{{ $exampleUrl }}" class="bg-blue-600 text-white px-3 py-2 rounded">فتح القالب</a>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
      <div>
        <div class="mb-1 text-sm text-gray-600">المرجع (PDF)</div>
        <iframe src="{{ $referenceUrl }}#view=FitH" title="reference"></iframe>
      </div>
      <div>
        <div class="mb-1 text-sm text-gray-600">القالب (HTML)</div>
        <iframe src="{{ $exampleUrl }}" title="example"></iframe>
      </div>
    </div>
  </div>
</body>
</html>
