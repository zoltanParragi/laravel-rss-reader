<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\OnlyGuests;
use App\Http\Middleware\OnlyUsers;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;

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
            return redirect()->route('welcome');
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

    Route::post('/add-rss-channel', [ChannelController::class, 'add_channel'])->name('add-rss-channel');
    
    Route::get('/my-channels', [UserController::class, 'user_channels'])->name('my-channels');
    
    Route::get('/deletechannel/{id}', [ChannelController::class, 'deletechannel'])->name('deletechannel');

    Route::get('/readnews/{id}', [ChannelController::class, 'read_news'])->name('readnews');
    
    Route::get('/savenews/{id}', [NewsController::class, 'save_news'])->name('savenews');

    Route::get('/logout', function() {
        Auth::logout();
        return redirect()->to('/');
    })->name('logout');
});
