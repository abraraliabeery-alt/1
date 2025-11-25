<?php

namespace App\Services;

use App\Models\Tender;
use App\Models\CompanyProfile;
use App\Models\TeamMember;
use Illuminate\Support\Facades\DB;

class TenderPdfService
{
    public function build(Tender $tender): array
    {
        $tender->load(['financialOffers.offerItems']);
        $company = CompanyProfile::query()->first();
        $team = TeamMember::query()->orderBy('order_index')->get();
        $projects = DB::table('tender_projects')->orderBy('order_index')->get();
        $certs = DB::table('certificates')->orderBy('order_index')->get();

        // compute financials if missing
        $fo = $tender->financialOffers->first();
        if ($fo) {
            $items = $fo->offerItems; $subtotal = 0; $vatSum = 0;
            foreach ($items as $it) {
                $line = (float)$it->qty * (float)$it->unit_price;
                $subtotal += $line;
                // if item vat not set, compute from rate
                $vatSum += ($it->vat !== null) ? (float)$it->vat : ($line * ((float)$fo->vat_rate/100.0));
            }
            $foComputed = [
                'currency' => $fo->currency,
                'vat_rate' => $fo->vat_rate,
                'subtotal' => $fo->subtotal ?: $subtotal,
                'total_vat' => $fo->total_vat ?: $vatSum,
                'total' => $fo->total ?: (($fo->subtotal ?: $subtotal) + ($fo->total_vat ?: $vatSum)),
                'items' => $items,
            ];
        } else {
            $foComputed = null;
        }

        $data = [
            'tender' => $tender,
            'company' => $company,
            'team' => $team,
            'projects' => $projects,
            'certificates' => $certs,
            'foComputed' => $foComputed,
        ];
        return ['tenders.print', $data];
    }
}
