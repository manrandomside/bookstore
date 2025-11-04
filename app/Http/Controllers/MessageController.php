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

    public function index()
    {
        $messages = Auth::user()->messages()->latest()->paginate(10);
        $totalMessages = Auth::user()->messages()->count();
        $repliedMessages = Auth::user()->messages()->whereNotNull('admin_reply')->count();
        $pendingMessages = Auth::user()->messages()->whereNull('admin_reply')->count();

        return view('user.messages-list', compact('messages', 'totalMessages', 'repliedMessages', 'pendingMessages'));
    }

    public function create()
    {
        return view('user.message-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $validated['user_id'] = Auth::id();

        Message::create($validated);

        return redirect()->route('messages.index')->with('success', 'Pesan berhasil dikirim. Admin akan meresponnya segera.');
    }

    public function show(Message $message)
    {
        if (Auth::user()->id != $message->user_id) {
            abort(403);
        }

        return view('user.message-detail', compact('message'));
    }

    public function indexAdmin(Request $request)
    {
        $query = Message::query();
        
        if ($request->filled('status')) {
            if ($request->status === 'unreplied') {
                $query->whereNull('admin_reply');
            } elseif ($request->status === 'replied') {
                $query->whereNotNull('admin_reply');
            }
        }

        $messages = $query->latest()->paginate(10);
        $totalMessages = Message::count();
        $unrepliedMessages = Message::whereNull('admin_reply')->count();
        $repliedMessages = Message::whereNotNull('admin_reply')->count();

        return view('admin.messages-list', compact('messages', 'totalMessages', 'unrepliedMessages', 'repliedMessages'));
    }

    public function showAdmin(Message $message)
    {
        return view('admin.message-detail', compact('message'));
    }

    public function reply(Request $request, Message $message)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'admin_reply' => 'required|string|min:10',
        ]);

        $message->admin_reply = $validated['admin_reply'];
        $message->admin_id = Auth::id();
        $message->replied_at = now();
        $message->save();

        return redirect()->back()->with('success', 'Balasan berhasil dikirim kepada user.');
    }

    public function replyAdmin(Request $request, Message $message)
    {
        return $this->reply($request, $message);
    }
}