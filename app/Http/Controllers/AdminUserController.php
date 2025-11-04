<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('admin.users-list', compact('users'));
    }

    public function show(User $user)
    {
        if ($user->role === 'admin') {
            abort(403);
        }

        $user->orders_count = $user->orders()->count();
        $user->total_spent = $user->orders()->where('payment_status', 'paid')->sum('total_amount');

        return response()->json($user);
    }

    public function toggleActive(User $user)
    {
        if ($user->role === 'admin') {
            abort(403);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', 'User berhasil ' . $status . '.');
    }
}