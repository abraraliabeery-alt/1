<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use App\Models\FinancialOffer;
use App\Models\OfferItem;
use App\Models\Client;
use App\Models\BoqHeader;
use App\Models\BoqItem;
use App\Models\Attachment;
use App\Models\PreviousProject;
use Illuminate\Http\Request;
use App\Http\Requests\TenderStoreRequest;
use Illuminate\Support\Facades\DB;

class TenderAdminController extends Controller
{
    public function index()
    {
        $tenders = Tender::latest()->paginate(20);
        return view('admin.tenders.index', compact('tenders'));
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get(['id','name']);
        return view('admin.tenders.create', compact('clients'));
    }

    public function store(TenderStoreRequest $request)
    {
        $validated = $request->validated();
        $data = collect($validated)->only([
            'title','client_id','client_name','competition_no','tender_no','submission_date','validity_days','notes'
        ])->toArray();
        if (!empty($data['client_id']) && empty($data['client_name'])) {
            $c = Client::find($data['client_id']);
            if ($c) { $data['client_name'] = $c->name; }
        }
        $data['created_by'] = auth()->id();

        $tender = DB::transaction(function() use ($data, $validated) {
            $tender = Tender::create($data);

            // Optional: BOQ rows
            $boqRows = data_get($validated, 'boq.rows', []);
            if (is_array($boqRows) && count(array_filter($boqRows, fn($r)=>!empty($r['item_name'] ?? null)))) {
                $header = BoqHeader::create([
                    'tender_id' => $tender->id,
                    'currency' => data_get($validated, 'boq.currency', 'SAR'),
                    'version_no' => 1,
                    'is_current' => true,
                ]);
                $order = 1;
                foreach ($boqRows as $r) {
                    if (empty($r['item_name'])) { continue; }
                    $qty = (float)($r['quantity'] ?? 0);
                    $unitPrice = (float)($r['unit_price'] ?? 0);
                    BoqItem::create([
                        'boq_id' => $header->id,
                        'item_name' => $r['item_name'],
                        'unit' => $r['unit'] ?? null,
                        'quantity' => $qty,
                        'unit_price' => $unitPrice,
                        'total_line' => $r['total_line'] ?? ($qty * $unitPrice),
                        'sort_order' => $order++,
                    ]);
                }
            }

            // Optional: attachments list
            $atts = data_get($validated, 'attachments', []);
            if (is_array($atts)) {
                $order = 1;
                foreach ($atts as $a) {
                    if (empty($a['label']) && empty($a['category'])) { continue; }
                    Attachment::create([
                        'tender_id' => $tender->id,
                        'file_id' => null,
                        'category' => $a['category'] ?? 'other',
                        'label' => $a['label'] ?? null,
                        'notes' => $a['notes'] ?? null,
                        'display_order' => $a['display_order'] ?? $order++,
                        'version_no' => 1,
                        'is_current' => true,
                    ]);
                }
            }

            // optional: quick financial offer & items via JSON
            $foData = data_get($validated, 'financial_offer');
            if (is_array($foData)) {
                $foData['tender_id'] = $tender->id;
                $fo = FinancialOffer::create($foData);

                $items = data_get($validated, 'financial_items', []);
                foreach ($items as $i => $item) {
                    OfferItem::create([
                        'financial_offer_id' => $fo->id,
                        'name' => data_get($item, 'name', 'بند'),
                        'description' => data_get($item, 'description'),
                        'qty' => data_get($item, 'qty', 1),
                        'unit' => data_get($item, 'unit'),
                        'unit_price' => data_get($item, 'unit_price', 0),
                        'vat' => data_get($item, 'vat', 0),
                        'total' => data_get($item, 'total', 0),
                        'order_index' => $i,
                    ]);
                }
            }

            // Optional: previous works
            $prevs = data_get($validated, 'prev', []);
            if (is_array($prevs)) {
                foreach ($prevs as $p) {
                    if (empty($p['project_name'])) { continue; }
                    PreviousProject::create([
                        'tender_id' => $tender->id,
                        'project_name' => $p['project_name'],
                        'client_name' => $p['client_name'] ?? null,
                        'details' => $p['details'] ?? null,
                        'year' => $p['year'] ?? null,
                        'duration_months' => $p['duration_months'] ?? null,
                        'value_amount' => $p['value_amount'] ?? null,
                    ]);
                }
            }

            return $tender;
        });

        return redirect()->route('admin.tenders.show', $tender);
    }

    public function show(Tender $tender)
    {
        $tender->load('financialOffers.offerItems');
        return view('admin.tenders.show', compact('tender'));
    }

    public function edit(Tender $tender)
    {
        $tender->load('financialOffers.offerItems');
        return view('admin.tenders.edit', compact('tender'));
    }

    public function update(Request $request, Tender $tender)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'competition_no' => 'nullable|string|max:255',
            'tender_no' => 'nullable|string|max:255',
            'submission_date' => 'nullable|date',
            'validity_days' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);
        $tender->update($data);
        return redirect()->route('admin.tenders.show', $tender)->with('ok', true);
    }
}
