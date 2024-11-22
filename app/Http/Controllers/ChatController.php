<?php

namespace App\Http\Controllers;

use App\Events\GotMessage;
use App\Jobs\SendMessage;
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
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        // Foydalanuvchilarni olish, hozirgi foydalanuvchini chiqarib tashlaydi
        $users = User::where('id', '!=', auth()->id())->get();
        $messages = [];

        foreach ($users as $user) {
            // Har bir foydalanuvchi bilan eng so'nggi xabarni olish
            $latestMessage = Chat::where(function ($query) use ($user) {
                $query->where('sender_id', auth()->id())
                      ->where('receiver_id', $user->id);
            })->orWhere(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', auth()->id());
            })->latest()->take(1)->first();

            // Har bir foydalanuvchi uchun eng so'nggi xabarni saqlash
            $messages[$user->id] = $latestMessage;
        }

        // `chat` viewga foydalanuvchilar va xabarlar bilan birga qaytarish
        return view('chat.index', compact('users', 'messages'));
    }

    /**
     * Store a new message between two users.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id)
    {
        // So'rovni tekshirish
        $validated = $request->validate([
            'message' => ['required', 'string'],
        ]);

        // Yangi xabarni saqlash
        $message = Chat::create([
            'message' => $validated['message'],
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
        ]);

        // Xabar yuborilishi bilan voqea chiqarish (masalan, real vaqtli bildirishnomalar)
        GotMessage::dispatch($message);

        // Muvaffaqiyatli yuborilganligi haqida qaytish
        return back()->with('success', 'Message sent.');
    }

    /**
     * Show the chat with a specific user.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $id)
    {
        // Foydalanuvchini olish
        $user = User::find($id);

        // Agar foydalanuvchi topilmasa, 404 xatosini ko'rsatish
        if (!$user) {
            abort(404);
        }

        // Hozirgi foydalanuvchi va tanlangan foydalanuvchi o'rtasidagi barcha xabarlarni olish
        $messages = Chat::query()
            ->where(function ($query) use ($user) {
                $query->where('sender_id', Auth::id())
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', Auth::id());
            })
            ->get();

        // Barcha foydalanuvchilarni olish (hozirgi foydalanuvchini chiqarib tashlaydi)
        $users = User::where('id', '!=', Auth::id())->get();

        // `chat` viewga foydalanuvchi, xabarlar va boshqa foydalanuvchilar bilan birga qaytarish
        return view('chat', ['user' => $user, 'messages' => $messages, 'users' => $users]);
    }

    /**
     * Get all messages between the current user and a specific user as JSON.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getMessages($id): JsonResponse
    {
        $user = User::query()->find($id);
        $auth = Auth::id();
        $partner = $user->id;

        // Xabarlarni olish
        $messages = Chat::query()
            ->where(function ($query) use ($auth, $partner) {
                $query->where('sender_id', $auth)
                    ->where('receiver_id', $partner);
            })
            ->orWhere(function ($query) use ($auth, $partner) {
                $query->where('sender_id', $partner)
                    ->where('receiver_id', $auth);
            })
            ->with(['sender', 'receiver'])
            ->get();

        return response()->json($messages);
    }

    /**
     * Store a new message via AJAX and return as JSON.
     *
     * @return JsonResponse
     */
    public function storeMessages(): JsonResponse
    {
        // Yangi xabarni saqlash
        $message = Chat::query()->create([
            'sender_id' => request('sender_id'),
            'receiver_id' => request('receiver_id'),
            'message' => request('message'),
        ]);

        // Xabarni yuborish uchun jobni yuborish
        SendMessage::dispatch($message);

        // Yangi xabarni JSON formatida qaytarish
        return response()->json($message);
    }
}
