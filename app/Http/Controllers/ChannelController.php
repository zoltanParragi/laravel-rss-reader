<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelRequest;
use App\Models\Channel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChannelController extends Controller
{
    function add_channel(ChannelRequest $request) {
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;
        Channel::create($validated);
        return redirect()->back()->with('successmsg', 'Channel saved :)');
    }

    function my_channels(Request $request) {
        $channels = Channel::where('user_id', '=', Auth::user()->id)->get();
        $request->session()->flash('channels', $channels);
        return view('my-channels');
    }

    function deletechannel($id) {
        Channel::find($id)->delete();
        return redirect()->back()->with('successmsg', 'Channel deleted :)');
    }
}
