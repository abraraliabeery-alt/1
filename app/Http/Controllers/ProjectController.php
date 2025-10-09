<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    // Public
    public function index(Request $request)
    {
        $q = Project::query();
        if ($request->filled('city')) $q->where('city', 'like', '%'.$request->city.'%');
        if ($request->filled('category')) $q->where('category', $request->category);
        if ($request->filled('status')) $q->where('status', $request->status);
        $projects = $q->latest()->paginate(9)->withQueryString();
        return view('projects.index', compact('projects'));
    }

    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        return view('projects.show', compact('project'));
    }

    // Staff (CRUD)
    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:190'],
            'client' => ['nullable','string','max:190'],
            'city' => ['nullable','string','max:120'],
            'category' => ['nullable','string','max:120'],
            'description' => ['nullable','string'],
            'status' => ['nullable','string','max:60'],
            'started_at' => ['nullable','date'],
            'finished_at' => ['nullable','date'],
            'is_featured' => ['nullable','boolean'],
            'cover' => ['nullable','image'],
            'gallery.*' => ['nullable','image'],
        ]);

        $slug = Str::slug($data['title'].'-'.Str::random(4));
        $coverPath = null;
        if ($request->hasFile('cover')) {
            $dir = public_path('uploads/projects'); if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            $name = 'cover_'.time().'_'.Str::random(6).'.'.$request->file('cover')->getClientOriginalExtension();
            $request->file('cover')->move($dir, $name);
            $coverPath = '/uploads/projects/'.$name;
        }
        $gallery = [];
        if ($request->hasFile('gallery')) {
            $dir = public_path('uploads/projects'); if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            foreach ((array)$request->file('gallery') as $idx => $file) {
                if (!$file) continue;
                $gname = 'g_'.time().'_'.Str::random(6).'_'.$idx.'.'.$file->getClientOriginalExtension();
                $file->move($dir, $gname);
                $gallery[] = '/uploads/projects/'.$gname;
            }
        }

        $project = Project::create([
            'title' => $data['title'],
            'slug' => $slug,
            'client' => $data['client'] ?? null,
            'city' => $data['city'] ?? null,
            'category' => $data['category'] ?? null,
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'completed',
            'started_at' => $data['started_at'] ?? null,
            'finished_at' => $data['finished_at'] ?? null,
            'is_featured' => (bool)($data['is_featured'] ?? false),
            'cover_image' => $coverPath,
            'gallery' => $gallery,
        ]);

        return redirect()->route('projects.show', $project->slug)->with('ok', 'تم إنشاء المشروع');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => ['required','string','max:190'],
            'client' => ['nullable','string','max:190'],
            'city' => ['nullable','string','max:120'],
            'category' => ['nullable','string','max:120'],
            'description' => ['nullable','string'],
            'status' => ['nullable','string','max:60'],
            'started_at' => ['nullable','date'],
            'finished_at' => ['nullable','date'],
            'is_featured' => ['nullable','boolean'],
            'cover' => ['nullable','image'],
            'gallery.*' => ['nullable','image'],
        ]);
        $project->title = $data['title'];
        $project->client = $data['client'] ?? null;
        $project->city = $data['city'] ?? null;
        $project->category = $data['category'] ?? null;
        $project->description = $data['description'] ?? null;
        $project->status = $data['status'] ?? $project->status;
        $project->started_at = $data['started_at'] ?? null;
        $project->finished_at = $data['finished_at'] ?? null;
        $project->is_featured = (bool)($data['is_featured'] ?? false);
        if ($request->hasFile('cover')) {
            $dir = public_path('uploads/projects'); if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            $name = 'cover_'.time().'_'.Str::random(6).'.'.$request->file('cover')->getClientOriginalExtension();
            $request->file('cover')->move($dir, $name);
            $project->cover_image = '/uploads/projects/'.$name;
        }
        if ($request->hasFile('gallery')) {
            $existing = is_array($project->gallery) ? $project->gallery : [];
            $dir = public_path('uploads/projects'); if (!is_dir($dir)) { @mkdir($dir, 0777, true); }
            foreach ((array)$request->file('gallery') as $idx => $file) {
                if (!$file) continue;
                $gname = 'g_'.time().'_'.Str::random(6).'_'.$idx.'.'.$file->getClientOriginalExtension();
                $file->move($dir, $gname);
                $existing[] = '/uploads/projects/'.$gname;
            }
            $project->gallery = $existing;
        }
        $project->save();
        return redirect()->route('projects.show', $project->slug)->with('ok', 'تم تحديث المشروع');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('ok', 'تم حذف المشروع');
    }
}
