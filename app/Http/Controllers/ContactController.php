<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Property;
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
            'message' => ['required','string','min:5','max:2000'],
        ]);
        $contact = Contact::create([
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'message' => $data['message'],
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
        $contact = Contact::create([
            'property_id' => $property->id,
            'name' => $data['name'] ?? optional(auth()->user())->name,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'message' => $data['message'],
        ]);
        Log::info('Property contact submitted', ['contact_id' => $contact->id, 'property_id' => $property->id]);
        return back()->with('ok', 'تم إرسال طلب التواصل بنجاح.');
    }
}
