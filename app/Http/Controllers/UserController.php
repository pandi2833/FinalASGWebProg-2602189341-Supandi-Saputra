<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $currentUserID = Auth::user()->id;
        $searchTerm = $request->input('search');

        $sentRequestUserIDs = DB::table('friend_requests')
            ->where('sender_id', '=', $currentUserID)
            ->pluck('receiver_id');

        $friendUserIDs = DB::table('friends')
            ->where('user_id', '=', $currentUserID)
            ->pluck('friend_id');

        $dataUser = User::whereNotIn('id', $sentRequestUserIDs)
            ->whereNotIn('id', $friendUserIDs)
            ->where('id', '!=', $currentUserID)
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('name', 'like', '%' . $searchTerm . '%');
            })
            ->get();

        return view('home', compact('dataUser'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
