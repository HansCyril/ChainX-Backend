<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders')->latest();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('role')) {
            $query->where('is_admin', $request->role === 'admin');
        }

        $status = $request->status ?? 'active';
        if ($status === 'active') {
            $query->where('is_archived', false);
        } elseif ($status === 'archived') {
            $query->where('is_archived', true);
        }

        $users = $query->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users', 'status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $data = $request->only(['name', 'email', 'password', 'phone', 'address', 'city', 'province', 'postal_code']);
        $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);
        $data['is_admin'] = $request->boolean('is_admin');
        $data['is_archived'] = false;

        User::create($data);

        return back()->with('success', 'Account created successfully.');
    }

    public function toggleArchive(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot archive your own account.');
        }
        $user->update(['is_archived' => !$user->is_archived]);
        $msg = $user->is_archived ? 'User archived.' : 'User restored.';
        return back()->with('success', $msg);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account here.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
