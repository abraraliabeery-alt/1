<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Property;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $property = Property::where('slug', $slug)->firstOrFail();
        $data = $request->validate([
            'body' => ['required','string','min:2','max:2000'],
            'name' => ['nullable','string','max:120'],
            'phone' => ['nullable','string','max:40'],
        ]);

        $comment = new Comment();
        $comment->property_id = $property->id;
        $comment->user_id = auth()->id();
        $comment->name = $data['name'] ?? optional(auth()->user())->name;
        $comment->phone = $data['phone'] ?? null;
        $comment->body = $data['body'];
        $comment->save();

        return back()->with('ok', 'تم إضافة التعليق');
    }

    public function destroy(Comment $comment)
    {
        // allow deletion for manager/staff only
        if (!auth()->check() || !(optional(auth()->user())->role === 'manager' || optional(auth()->user())->is_staff)) {
            abort(403);
        }
        $comment->delete();
        return back()->with('ok', 'تم حذف التعليق');
    }
}
