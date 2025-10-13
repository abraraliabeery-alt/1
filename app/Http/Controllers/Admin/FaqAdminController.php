<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqAdminController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('sort_order')->latest()->paginate(20);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        $faq = new Faq(['status' => 'published', 'sort_order' => 0]);
        return view('admin.faqs.create', compact('faq'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'question' => ['required','string','max:255'],
            'answer' => ['required','string'],
            'status' => ['required','in:published,draft'],
            'sort_order' => ['nullable','integer','min:0','max:999999'],
        ]);
        $data['sort_order'] = (int)($data['sort_order'] ?? 0);
        Faq::create($data);
        return redirect()->route('admin.faqs.index')->with('ok', 'تمت إضافة سؤال شائع');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $data = $request->validate([
            'question' => ['required','string','max:255'],
            'answer' => ['required','string'],
            'status' => ['required','in:published,draft'],
            'sort_order' => ['nullable','integer','min:0','max:999999'],
        ]);
        $faq->update($data);
        return redirect()->route('admin.faqs.index')->with('ok', 'تم تحديث السؤال الشائع');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('ok', 'تم حذف السؤال الشائع');
    }
}
