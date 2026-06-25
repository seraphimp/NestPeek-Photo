<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $conversations = Conversation::where('client_id', $user->id)
            ->orWhere('creator_id', $user->id)
            ->with(['client', 'creator', 'latestMessage'])
            ->orderByDesc('last_message_at')
            ->get();

        return view('messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        // Make sure only participants can view
        abort_unless(
            in_array(auth()->id(), [$conversation->client_id, $conversation->creator_id]),
            403
        );

        $messages = $conversation->messages()->with('sender')->get();

        // Mark as read for the current user
        $field = auth()->id() === $conversation->client_id ? 'client_unread' : 'creator_unread';
        $conversation->update([$field => false]);

        return view('messages.show', compact('conversation', 'messages'));
    }

    public function send(Request $request, Conversation $conversation)
    {
        abort_unless(
            in_array(auth()->id(), [$conversation->client_id, $conversation->creator_id]),
            403
        );

        $request->validate(['body' => 'required|string|max:5000']);

        $message = $conversation->messages()->create([
            'sender_id' => auth()->id(),
            'body'      => $request->body,
        ]);

        $isClient = auth()->id() === $conversation->client_id;

        $conversation->update([
            'last_message_at' => now(),
            'client_unread'   => ! $isClient,
            'creator_unread'  => $isClient,
        ]);

        return response()->json(['message' => $message->load('sender')]);
    }
}
