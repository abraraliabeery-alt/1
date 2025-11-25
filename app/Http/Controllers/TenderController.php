<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Services\TenderPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenderController extends Controller
{
    public function previewPdf(Tender $tender, TenderPdfService $service)
    {
        [$view, $data] = $service->build($tender);
        $html = view($view, $data)->render();
        // Save the rendered HTML for quick diagnosis
        try { \Illuminate\Support\Facades\Storage::put('last-html.html', $html); } catch (\Throwable $e) {}
        // If ?debug=1 return raw HTML to verify layout outside mPDF
        if (request()->boolean('debug')) {
            return response($html)->header('Content-Type', 'text/html; charset=UTF-8');
        }

        $pdf = \PDF::loadView($view, $data, [], [
            'format' => 'A4',
            'default_font' => 'dejavusans',
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
            'directionality' => 'rtl',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'useOTL' => 0xFF,
            'useKashida' => 75,
            'tempDir' => storage_path('app/pdf-temp'),
        ]);
        return $pdf->stream('tender-'.$tender->id.'.pdf');
    }

    public function generatePdf(Tender $tender, TenderPdfService $service)
    {
        [$view, $data] = $service->build($tender);
        $html = view($view, $data)->render();
        $pdf = \PDF::loadHTML($html, [
            'format' => 'A4',
            'default_font' => 'dejavusans',
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
            'directionality' => 'rtl',
            'autoScriptToLang' => true,
            'autoLangToFont' => true,
            'useOTL' => 0xFF,
            'useKashida' => 75,
            'tempDir' => storage_path('app/pdf-temp'),
        ]);
        $year = now()->format('Y');
        $path = "tenders/{$year}/{$tender->id}.pdf";
        $full = storage_path('app/public/'.$path);
        if (!is_dir(dirname($full))) { @mkdir(dirname($full), 0775, true); }
        file_put_contents($full, $pdf->output());
        $tender->update(['pdf_path' => 'storage/'.$path]);
        return response()->json(['ok' => true, 'path' => url($tender->pdf_path)]);
    }

    public function htmlPreview(Tender $tender, TenderPdfService $service)
    {
        [$view, $data] = $service->build($tender);
        return view($view, $data);
    }

    public function templateExample()
    {
        $brandColor = '#0B5FAD';
        $tender = Tender::with([
            'client',
            'boqHeaders' => function($q){ $q->where('is_current', true)->with(['items']); },
            'previousProjects',
            'attachments.file',
            'financialOffers',
        ])->latest('id')->first();

        $items = collect();
        if ($tender && $tender->boqHeaders->first()) {
            $items = $tender->boqHeaders->first()->items;
        }

        $perPage = 12; // rows per BOQ page
        $boqChunks = [];
        $offsets = [];
        if ($items->count()) {
            $chunks = $items->chunk($perPage)->values();
            $start = 0;
            foreach ($chunks as $chunk) {
                $boqChunks[] = $chunk;
                $offsets[] = $start;
                $start += $chunk->count();
            }
        }

        $previousWorks = $tender?->previousProjects ?? collect();
        $fo = $tender?->financialOffers?->first();
        $attachments = $tender?->attachments ?? collect();

        return view('tenders.example', compact('brandColor','tender','boqChunks','offsets','previousWorks','fo','attachments'));
    }

    public function exampleForTender(Tender $tender)
    {
        $brandColor = '#0B5FAD';
        $tender->load([
            'client',
            'boqHeaders' => function($q){ $q->where('is_current', true)->with(['items']); },
            'previousProjects',
            'attachments.file',
            'financialOffers',
        ]);

        $items = collect();
        if ($tender->boqHeaders->first()) {
            $items = $tender->boqHeaders->first()->items;
        }

        $perPage = 12;
        $boqChunks = [];
        $offsets = [];
        if ($items->count()) {
            $chunks = $items->chunk($perPage)->values();
            $start = 0;
            foreach ($chunks as $chunk) {
                $boqChunks[] = $chunk;
                $offsets[] = $start;
                $start += $chunk->count();
            }
        }

        $previousWorks = $tender->previousProjects ?? collect();
        $fo = $tender->financialOffers?->first();
        $attachments = $tender->attachments ?? collect();
        return view('tenders.example', compact('brandColor','tender','boqChunks','offsets','previousWorks','fo','attachments'));
    }

    public function templateCompare()
    {
        $brandColor = '#0B5FAD';
        $referenceUrl = url('ex.pdf');
        $exampleUrl = route('admin.tenders.template.example');
        return view('tenders.compare', compact('brandColor', 'referenceUrl', 'exampleUrl'));
    }

    public function downloadPdf(Tender $tender)
    {
        abort_if(empty($tender->pdf_path) || !file_exists(public_path(str_replace('storage/', 'storage/', $tender->pdf_path))), 404);
        return response()->download(public_path($tender->pdf_path));
    }
}
