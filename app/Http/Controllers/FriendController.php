<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Models\FriendRequest;
use App\Models\User;
use App\Notifications\FriendRequestAccepted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function index()
    {
        $currentUserID = Auth::user()->id;
        $dataFriend = Friend::where('user_id', '=', $currentUserID)->join('users', 'users.id', '=', 'friends.friend_id')->get(['users.*']);

        return view('friend', compact('dataFriend'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $currentUserID = Auth::user()->id;
        $friendID = $request->input('friend_id');
        $request_id = $request->input('request_id');

        $friend = Friend::create([
            'user_id' => $currentUserID,
            'friend_id' => $friendID
        ]);

        $friend2 = Friend::create([
            'user_id' => $friendID,
            'friend_id' => $currentUserID
        ]);

        $updateRequest = FriendRequest::find($request_id);
        $updateRequest->status = 'accepted';
        $updateRequest->save();

        $receiver = User::find($friendID);
        $receiver->notify(new FriendRequestAccepted($currentUserID));

        return redirect()->route('friend-request.index')->with('success', 'Friend request accepted and notification sent!');
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

    public function destroy(string $id)
    {
        //
    }
}
