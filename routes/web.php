<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Channel;
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

    Route::get('/add-rss-channel', function() {
        return view('add-rss-channel');
    })->name('add-rss-channel');

    Route::post('/add-rss-channel', function(Request $request) {
        $validated = $request->validate([
            'channel_name'=> 'required|min:3|max:20',
            'url'=>'required|active_url|unique:channels',
        ]);

        $validated['user-id'] = Auth::user()->id;
        Channel::create($validated);

        return redirect()->back()->with('successmsg', 'Channel saved :)');
    })->name('add-rss-channel');
   
    Route::get('/my-channels', function(Request $request) {
        $channels = Channel::where('user-id', '=', Auth::user()->id)->get();
        $request->session()->flash('channels', $channels);
        return view('my-channels');
    })->name('my-channels');

    Route::get('/savenews/{id}', function($id) {
        $channel = Channel::find($id);
        //dd($channel->url);
        $content = file_get_contents('https://www.hirstart.hu/site/publicrss.php?pos=balrovat&pid=51');
        //$content = file_get_contents($channel->url);
        $contetn_array = new \SimpleXMLElement($content);
        //$x = json_encode($contetn_array);

        /* if($channel) {
            $channel->news = json_encode($contetn_array->channel->item[0]);
            //$channel->news = $contetn_array->channel->item[0] -> title;
            $channel->save();
        } */
        /* foreach ($contetn_array->channel->item as $entry) {
            $channel->updateorcreate([
                'url' => $entry->link
            ], [
                "user-id" => Auth::user()->id,
                "channel_name" => $channel -> channel_name,
                "title" => $entry->title,
                "description" => $entry->description,
                "author" => $entry->author,
                "pub_date" => $entry->pubDate,
                "image" => $entry->enclosure
            ]);

            //$channel->update(['last_refresh'=>time()]);
        } */
        
        dd($contetn_array);

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
