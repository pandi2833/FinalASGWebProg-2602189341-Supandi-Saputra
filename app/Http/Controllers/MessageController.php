<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $senderID = Auth::user()->id;
        $receiverID = $request->input('friend_id');

        $request->validate([
            'new_message' => 'required|string|max:255',
        ]);

        Message::create([
            'sender_id' => $senderID,
            'receiver_id' => $receiverID,
            'message' => $request->input('new_message'),
        ]);

        return redirect()->route('message.show', $receiverID);
    }

    public function show(string $id)
    {
        $currentUserID = Auth::user()->id;
        $friend = User::findOrFail($id);

        $messages = Message::where(function ($query) use ($currentUserID, $id) {
            $query->where('sender_id', $currentUserID)
                ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($currentUserID, $id) {
            $query->where('sender_id', $id)
                ->where('receiver_id', $currentUserID);
        })->orderBy('created_at', 'asc')->get();

        return view('message', compact('friend', 'messages'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
