<?php

namespace App\Http\Controllers;

use App\Events\GotMessage;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show the list of users and the latest messages.
     */
    public function index(): Application|Factory|View
    {
        $authId = auth()->id();

        $users = User::where('id', '!=', $authId)->get();

        $messages = [];

        foreach ($users as $user) {
            $latestMessage = Chat::where(function ($query) use ($authId, $user) {
                $query->where('sender_id', $authId)
                    ->where('receiver_id', $user->id);
            })->orWhere(function ($query) use ($authId, $user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $authId);
            })->latest()->first();

            $messages[$user->id] = $latestMessage;
        }

        return view('chat.index', compact('users', 'messages'));
    }

    /**
     * Store a new message between two users.
     */
    public function store(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'room_id' => 'required|exists:rooms,id', 
        ]);

        $message = Chat::create([
            'message' => $validated['message'],
            'room_id' => $validated['room_id'],
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
        ]);

        GotMessage::dispatch($message);

        return back()->with('success', 'Message sent.');
    }

    /**
     * Show the chat with a specific user.
     */
    public function show(string $id): View
    {
        $authId = Auth::id();
        $user = User::findOrFail($id);

        
        $messages = Chat::where(function ($query) use ($authId, $id) {
            $query->where('sender_id', $authId)
                ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($authId, $id) {
            $query->where('sender_id', $id)
                ->where('receiver_id', $authId);
        })->get();

        $users = User::where('id', '!=', $authId)->get();

        return view('chat', compact('user', 'messages', 'users'));
    }

    /**
     * Get all messages between the current user and a specific user as JSON.
     */
    public function getMessages(int $id): JsonResponse
    {
        $authId = Auth::id();

        $messages = Chat::where(function ($query) use ($authId, $id) {
            $query->where('sender_id', $authId)
                ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($authId, $id) {
            $query->where('sender_id', $id)
                ->where('receiver_id', $authId);
        })->with(['sender', 'receiver'])->get();

        return response()->json($messages);
    }

    /**
     * Store a new message via AJAX and return as JSON.
     */
    public function storeMessages(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'receiver_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id', 
        ]);

        $message = Chat::create([
            'message' => $validated['message'],
            'room_id' => $validated['room_id'],
            'sender_id' => Auth::id(),
            'receiver_id' => $validated['receiver_id'],
        ]);

        GotMessage::dispatch($message);

        return response()->json($message, 201);
    }
}
