<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    // Public
    public function index(Request $request)
    {
        $q = Event::query();
        if ($request->filled('city')) $q->where('city', 'like', '%'.$request->city.'%');
        if ($request->filled('category')) $q->where('category', $request->category);
        if ($request->get('upcoming')) $q->where(function($sub){ $sub->whereNull('ends_at')->orWhere('ends_at', ">=", now()); });
        $events = $q->orderByDesc('is_featured')->orderBy('starts_at')->latest()->paginate(12)->withQueryString();
        return view('events.index', compact('events'));
    }

    public function show(string $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        return view('events.show', compact('event'));
    }

    // Staff
    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:190'],
            'summary' => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
            'category' => ['nullable','string','max:120'],
            'city' => ['nullable','string','max:120'],
            'venue' => ['nullable','string','max:190'],
            'starts_at' => ['nullable','date'],
            'ends_at' => ['nullable','date','after_or_equal:starts_at'],
            'is_featured' => ['nullable','boolean'],
            'status' => ['nullable','in:scheduled,finished,canceled'],
            'cover' => ['nullable','image']
        ]);
        $slug = Str::slug($data['title'].'-'.Str::random(4));
        $cover = null;
        if ($request->hasFile('cover')) {
            $dir = public_path('uploads/events'); if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            $name = 'e_'.time().'_'.Str::random(6).'.'.$request->file('cover')->getClientOriginalExtension();
            $request->file('cover')->move($dir, $name);
            $cover = '/uploads/events/'.$name;
        }
        $event = Event::create([
            'title' => $data['title'],
            'slug' => $slug,
            'summary' => $data['summary'] ?? null,
            'description' => $data['description'] ?? null,
            'category' => $data['category'] ?? null,
            'city' => $data['city'] ?? null,
            'venue' => $data['venue'] ?? null,
            'cover_image' => $cover,
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
            'is_featured' => (bool)($data['is_featured'] ?? false),
            'status' => $data['status'] ?? 'scheduled',
        ]);
        return redirect()->route('events.show', $event->slug)->with('ok', 'تم إنشاء الفعالية');
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => ['required','string','max:190'],
            'summary' => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
            'category' => ['nullable','string','max:120'],
            'city' => ['nullable','string','max:120'],
            'venue' => ['nullable','string','max:190'],
            'starts_at' => ['nullable','date'],
            'ends_at' => ['nullable','date','after_or_equal:starts_at'],
            'is_featured' => ['nullable','boolean'],
            'status' => ['nullable','in:scheduled,finished,canceled'],
            'cover' => ['nullable','image']
        ]);
        $event->fill([
            'title' => $data['title'],
            'summary' => $data['summary'] ?? null,
            'description' => $data['description'] ?? null,
            'category' => $data['category'] ?? null,
            'city' => $data['city'] ?? null,
            'venue' => $data['venue'] ?? null,
            'starts_at' => $data['starts_at'] ?? null,
            'ends_at' => $data['ends_at'] ?? null,
            'is_featured' => (bool)($data['is_featured'] ?? false),
            'status' => $data['status'] ?? 'scheduled',
        ]);
        if ($request->hasFile('cover')) {
            $dir = public_path('uploads/events'); if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            $name = 'e_'.time().'_'.Str::random(6).'.'.$request->file('cover')->getClientOriginalExtension();
            $request->file('cover')->move($dir, $name);
            $event->cover_image = '/uploads/events/'.$name;
        }
        $event->save();
        return redirect()->route('events.show', $event->slug)->with('ok', 'تم تحديث الفعالية');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('ok', 'تم حذف الفعالية');
    }
}
