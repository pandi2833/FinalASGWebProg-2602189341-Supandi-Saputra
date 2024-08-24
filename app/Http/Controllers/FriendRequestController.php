<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    public function index()
    {
        $currentUserID = Auth::user()->id;
        $friendRequest = FriendRequest::where('friend_requests.receiver_id', '=', $currentUserID)->where('friend_requests.status', '=', 'pending')->join('users', 'users.id', '=', 'friend_requests.sender_id')->get(['friend_requests.id as request_id', 'users.*']);

        return view('request', compact('friendRequest'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $sender_id = Auth::user()->id;
        $receiver_id = $request->input('receiver_id');

        $friendRequest = FriendRequest::create([
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id
        ]);

        if ($friendRequest) {
            return redirect()->route('user.index')->with('success', 'Friend request sent');
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(FriendRequest $friendRequest)
    {
        $deleteRequest = FriendRequest::destroy($friendRequest->id);

        return redirect()->route('friend-request.index')->with('success', 'Succesfully Delete');
    }
}
