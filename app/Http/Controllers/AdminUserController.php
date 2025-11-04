<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        if ($user->isAdmin()) {
            abort(403);
        }

        return view('admin.users.show', compact('user'));
    }

    public function toggleActive(User $user)
    {
        if ($user->isAdmin()) {
            abort(403);
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ' . $status . '.');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}