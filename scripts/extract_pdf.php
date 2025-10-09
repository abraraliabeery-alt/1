<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Smalot\PdfParser\Parser;

try {
    $input = __DIR__ . '/../Top Level Profile.pdf';
    if (!file_exists($input)) {
        throw new RuntimeException("Input PDF not found: " . $input);
    }

    $outputDir = __DIR__ . '/../storage/app/pdf';
    if (!is_dir($outputDir)) {
        if (!mkdir($outputDir, 0777, true) && !is_dir($outputDir)) {
            throw new RuntimeException("Failed to create output directory: " . $outputDir);
        }
    }

    $output = $outputDir . '/Top Level Profile.txt';

    $parser = new Parser();
    $pdf = $parser->parseFile($input);
    $text = $pdf->getText();

    file_put_contents($output, $text);

    echo "OK: Extracted to $output\n";
} catch (Throwable $e) {
    fwrite(STDERR, 'ERROR: ' . $e->getMessage() . "\n");
    exit(1);
}
