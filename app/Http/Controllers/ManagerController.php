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

    public function employees(Request $request)
    {
        $q = User::query()->where('is_staff', true);
        if ($search = $request->input('q')) {
            $q->where(function($qq) use ($search) {
                $qq->where('name', 'like', "%{$search}%")
                   ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $users = $q->orderBy('name')->paginate(15)->withQueryString();
        return view('admin.employees', compact('users'));
    }

    public function users(Request $request)
    {
        $q = User::query();
        if ($search = $request->input('q')) {
            $q->where(function($qq) use ($search) {
                $qq->where('name', 'like', "%{$search}%")
                   ->orWhere('email', 'like', "%{$search}%");
            });
        }
        // Optional filter: staff=1 or staff=0
        if ($request->filled('staff')) {
            $q->where('is_staff', (bool) $request->boolean('staff'));
        }
        // Sorting
        $sort = $request->input('sort', 'created_at');
        $dir  = strtolower($request->input('dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $allowed = ['name','email','is_staff','created_at'];
        if (!in_array($sort, $allowed, true)) { $sort = 'created_at'; }
        $q->orderBy($sort, $dir);

        $users = $q->paginate(15)->withQueryString();

        if ($request->ajax()) {
            return response()->view('admin.partials.users_tbody', compact('users'));
        }
        return view('admin.users', compact('users'));
    }
}
