<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function promoteForm()
    {
        return view('admin.promote');
    }

    public function promote(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email','exists:users,email']
        ]);
        $user = User::where('email', $data['email'])->firstOrFail();
        $user->is_staff = 1; // mark as staff
        $user->save();
        return back()->with('ok', 'تمت ترقية المستخدم إلى موظف بنجاح');
    }

    public function nonEmployees(Request $request)
    {
        $q = User::query()->where('is_staff', false);
        if ($search = $request->input('q')) {
            $q->where(function($qq) use ($search) {
                $qq->where('name', 'like', "%{$search}%")
                   ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $users = $q->orderByDesc('created_at')->paginate(15)->withQueryString();
        return view('admin.non_employees', compact('users'));
    }
}
