<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    function user_channels(Request $request) {
        $channels = User::find(Auth::user()->id)->getChannels;
        $request->session()->flash('channels', $channels);
        return view('my-channels');
    }
}
