<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->is_staff;
    }

    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'client_id' => ['nullable','exists:clients,id'],
            'client_name' => ['nullable','string','max:255'],
            'competition_no' => ['nullable','string','max:255'],
            'tender_no' => ['nullable','string','max:255'],
            'submission_date' => ['nullable','date'],
            'validity_days' => ['nullable','integer'],
            'notes' => ['nullable','string'],

            // financial offer
            'financial_offer.currency' => ['nullable','string','max:8'],
            'financial_offer.vat_rate' => ['nullable','numeric'],
            'financial_offer.discount' => ['nullable','numeric'],
            'financial_offer.subtotal' => ['nullable','numeric'],
            'financial_offer.total_vat' => ['nullable','numeric'],
            'financial_offer.total' => ['nullable','numeric'],
            'financial_offer.total_text' => ['nullable','string'],

            // financial offer items (array of rows)
            'financial_items' => ['array'],
            'financial_items.*.name' => ['nullable','string','max:255'],
            'financial_items.*.description' => ['nullable','string'],
            'financial_items.*.qty' => ['nullable','numeric'],
            'financial_items.*.unit' => ['nullable','string','max:64'],
            'financial_items.*.unit_price' => ['nullable','numeric'],
            'financial_items.*.vat' => ['nullable','numeric'],
            'financial_items.*.total' => ['nullable','numeric'],

            // BOQ rows
            'boq.currency' => ['nullable','string','max:8'],
            'boq.rows' => ['array'],
            'boq.rows.*.item_name' => ['nullable','string','max:255'],
            'boq.rows.*.unit' => ['nullable','string','max:64'],
            'boq.rows.*.quantity' => ['nullable','numeric'],
            'boq.rows.*.unit_price' => ['nullable','numeric'],

            // attachments
            'attachments' => ['array'],
            'attachments.*.category' => ['nullable','string','max:64'],
            'attachments.*.label' => ['nullable','string','max:255'],
            'attachments.*.notes' => ['nullable','string'],
            'attachments.*.display_order' => ['nullable','integer'],

            // previous works
            'prev' => ['array'],
            'prev.*.project_name' => ['nullable','string','max:255'],
            'prev.*.client_name' => ['nullable','string','max:255'],
            'prev.*.details' => ['nullable','string'],
            'prev.*.year' => ['nullable','integer'],
            'prev.*.duration_months' => ['nullable','integer'],
            'prev.*.value_amount' => ['nullable','numeric'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            $clientId = $this->input('client_id');
            $clientName = trim((string)$this->input('client_name'));
            if (empty($clientId) && $clientName === '') {
                $v->errors()->add('client_name', 'يجب اختيار جهة من القائمة أو كتابة اسم الجهة.');
            }
        });
    }
}
