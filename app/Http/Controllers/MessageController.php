<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('messages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'unread';

        Message::create($validated);

        return redirect()->route('messages.index')->with('success', 'Pesan berhasil dikirim ke admin.');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $messages = Message::with('user')->orderBy('created_at', 'desc')->get();
            return view('admin.messages.index', compact('messages'));
        }

        $messages = $user->messages()->orderBy('created_at', 'desc')->get();
        return view('messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        $user = Auth::user();

        if ($user->isUser() && $message->user_id != $user->id) {
            abort(403);
        }

        if ($message->isUnread()) {
            $message->markAsRead();
        }

        return view('messages.show', compact('message'));
    }

    public function reply(Request $request, Message $message)
    {
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'admin_reply' => 'required|string',
        ]);

        $message->markAsReplied($validated['admin_reply'], $user->id);

        return redirect()->route('admin.messages.index')->with('success', 'Balasan berhasil dikirim.');
    }
}