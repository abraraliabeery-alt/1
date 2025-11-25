<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function storeHome(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable','string','max:120'],
            'email' => ['nullable','email','max:190'],
            'phone' => ['nullable','string','max:40'],
            'type' => ['nullable','string','max:190'],
            'message' => ['required','string','min:5','max:2000'],
        ]);
        $refCode = $request->cookie('ref_code') ?? session('ref_code');
        $utmSource = $request->cookie('utm_source') ?? session('utm_source');
        $utmMedium = $request->cookie('utm_medium') ?? session('utm_medium');
        $utmCampaign = $request->cookie('utm_campaign') ?? session('utm_campaign');
        $refUser = $refCode ? User::where('affiliate_code', $refCode)->first() : null;
        $msg   = $data['message'];

        $contact = Contact::create([
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'message' => $msg,
            'ref_code' => $refCode,
            'ref_user_id' => optional($refUser)->id,
            'utm_source' => $utmSource,
            'utm_medium' => $utmMedium,
            'utm_campaign' => $utmCampaign,
        ]);
        Log::info('Home contact submitted', ['contact_id' => $contact->id]);
        return back()->with('ok', 'تم إرسال رسالتك بنجاح، سنعود إليك قريبًا.');
    }

    public function storeProperty(Request $request, string $slug)
    {
        $property = Property::where('slug', $slug)->firstOrFail();
        $data = $request->validate([
            'name' => ['nullable','string','max:120'],
            'email' => ['nullable','email','max:190'],
            'phone' => ['nullable','string','max:40'],
            'message' => ['required','string','min:5','max:2000'],
        ]);
        $refCode = $request->cookie('ref_code') ?? session('ref_code');
        $utmSource = $request->cookie('utm_source') ?? session('utm_source');
        $utmMedium = $request->cookie('utm_medium') ?? session('utm_medium');
        $utmCampaign = $request->cookie('utm_campaign') ?? session('utm_campaign');
        $refUser = $refCode ? User::where('affiliate_code', $refCode)->first() : null;
        $contact = Contact::create([
            'property_id' => $property->id,
            'name' => $data['name'] ?? optional(auth()->user())->name,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'message' => $data['message'],
            'ref_code' => $refCode,
            'ref_user_id' => optional($refUser)->id,
            'utm_source' => $utmSource,
            'utm_medium' => $utmMedium,
            'utm_campaign' => $utmCampaign,
        ]);
        Log::info('Property contact submitted', ['contact_id' => $contact->id, 'property_id' => $property->id]);
        return back()->with('ok', 'تم إرسال طلب التواصل بنجاح.');
    }
}
