<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class ContactAdminController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::query()->latest()->paginate(20);
        $staff = User::query()->orderBy('name')->get(['id','name']);
        return view('admin.contacts.index', compact('contacts','staff'));
    }

    public function show(Contact $contact)
    {
        $staff = User::query()->orderBy('name')->get(['id','name']);
        return view('admin.contacts.show', compact('contact','staff'));
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'status' => 'nullable|in:new,in_progress,closed',
            'follow_up_at' => 'nullable|date',
            'assigned_employee_id' => 'nullable|exists:users,id',
            'note' => 'nullable|string',
        ]);
        $contact->update($data);
        return back()->with('ok', 'تم تحديث الحالة.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('ok', 'تم حذف الرسالة');
    }
}
