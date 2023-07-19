<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Channel;
use App\Models\Newsitem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\OnlyGuests;
use App\Http\Middleware\OnlyUsers;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::group(['middleware' => [OnlyGuests::class]], function() {

    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', function(Request $request) {
        $result = Auth::attempt(['email'=>$request->email, 'password'=>$request->password]);
        if($result) {
            $request->session()->regenerate();
            return redirect()->route('profile')->with('successmsg', __('Successful login'));
        } else {
            return redirect()->back()->with('errormsg', __('The email password pair does not match.'))->withInput();
        }
    });

    Route::get('/register', function () {
        return view('register');
    })->name('register');

    Route::post('/register', function(Request $request) {
        $validated = $request->validate([
            'name'=> 'required|min:3|max:20',
            'email'=>'required|email|unique:users',
            'password'=>'min:4|max:20|confirmed',
        ]);

        User::create($validated);

        return redirect()->back()->with('successmsg', 'Successfull registration :)');
    });
});

Route::group(['middleware'=>[OnlyUsers::class]], function() {
    Route::get('/profile', function() {
        return view('profile');
    })->name('profile');

    // rss feed source: https://news.un.org/en/rss-feeds

    Route::get('/add-rss-channel', function() {
        return view('add-rss-channel');
    })->name('add-rss-channel');

    Route::post('/add-rss-channel', function(Request $request) {
        $validated = $request->validate([
            'channel_name'=> 'required|min:3|max:20',
            'url'=>'required|active_url|unique:channels',
        ]);

        $validated['user_id'] = Auth::user()->id;
        Channel::create($validated);

        return redirect()->back()->with('successmsg', 'Channel saved :)');
    })->name('add-rss-channel');
   
    Route::get('/my-channels', function(Request $request) {
        $channels = Channel::where('user_id', '=', Auth::user()->id)->get();
        $request->session()->flash('channels', $channels);
        return view('my-channels');
    })->name('my-channels');

    Route::get('/readnews/{id}', function($id) {
        return view('readnews', [
            'newsitems' => Newsitem::where('channel_id', '=', $id)->paginate(10),
            'channel_name' => Channel::find($id)->channel_name,
            //'channel_name' => Channel::where('id', "=", $id)->first()->channel_name,
            ] 
        );
    })->name('readnews');


    Route::get('/savenews/{id}', function($id) {
        $channel = Channel::find($id);
        $content = file_get_contents($channel->url);
        $contetn_array = new \SimpleXMLElement($content);

        foreach ($contetn_array->channel->item as $entry) {
            Newsitem::updateOrCreate(
                ['link' => '$entry->link'],
                [
                    'channel_id' => $channel->id,
                    "title" => $entry->title,
                    "link" => $entry->link,
                    "description" => $entry->description,
                    "img_url" => $entry->enclosure->attributes()->url,
                    "pub_date" => $entry->pubDate,
                ]
            );
        }

        return redirect()->back()->with('successmsg', 'News saved/updated :)');

    })->name('savenews');
    
    /*     Route::get('/deletechannel/{id}', function($id) {
        
           Channel::find($id)->delete();
           return redirect()->back()->with('successmsg', 'Channel deleted :)');
        });
     */
    Route::get('/deletechannel/{id}', function($id) {
        Channel::find($id)->delete();
        return redirect()->back()->with('successmsg', 'Channel deleted :)');
     })->name('deletechannel');

    Route::get('/logout', function() {
        Auth::logout();
        return redirect()->to('/');
    })->name('logout');
});
