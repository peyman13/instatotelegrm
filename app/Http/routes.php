<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Telegram\Bot\Api;
use App\Http\Controllers\InstagaramController as instagramClass;
use Input;
use Illuminate\Http\Request;


Route::get('/', 'HomeController@index');


// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// api token
Route::post('api/register', 'TokenAuthController@register');
Route::post('api/authenticate', 'TokenAuthController@authenticate');
Route::get('api/authenticate/user', 'TokenAuthController@getAuthenticatedUser');


Route::resource('api/todo', 'TodoController');

// instagram
Route::get('instagram/redirect', 'InstagaramController@redirect');

Route::group(['middleware' => 'instagramauth', 'prefix' => 'instagram'], function () {
	Route::get('/index', 'InstagaramController@index');
	Route::get('/selfMedia', 'InstagaramController@selfMedia');
	Route::get('/media', 'InstagaramController@getMedia');
	Route::get('/likemedia', 'InstagaramController@getLikeMedia');
	Route::get('/commentmedia', 'InstagaramController@getCommentMedia');
	Route::get('/shortcode', 'InstagaramController@getShortCode');
	Route::get('/search', 'InstagaramController@shearchUser');
	Route::get('/timeline', 'InstagaramController@getTimeLine');
	Route::get('/follows', 'InstagaramController@follows');
	Route::get('/followed_by', 'InstagaramController@followed_by');
});

// telegram
Route::get('telegram/api', function(){

	$telegram = new Api('210338043:AAFZpqmwW8aTXBaQ5K37h4IyiPY84_onGqI');
	$response = $telegram->getMe();
	return redirect()->back();
});

Route::get('telegram/send', function(Request $request){

	$telegram = new Api('210338043:AAFZpqmwW8aTXBaQ5K37h4IyiPY84_onGqI');
	$instagramApi =	new instagramClass;

	$photo = Input::get('photo');
	preg_match("/^http(s|):\/\/.*.jpg/", $photo , $matches, PREG_OFFSET_CAPTURE);

	$response = $telegram->sendPhoto([
		'chat_id' => '@instatotelegram', 
		'photo' => $matches[0][0], 
		'caption' => '👍'.Input::get('like').' 💬 '.Input::get('comment')."\n".Input::get('caption')
	]);

	$comment = $instagramApi->getCommentMedia($request, Input::get('mediaid'));

	foreach($comment['data'] as $key => $value) {
		$response = $telegram->sendMessage([
			'chat_id' => '@instatotelegram', 
			'text' => "instagram.com/".$value['from']['username']." : ".$value['text']
		]);
	}

	$like = $instagramApi->getLikeMedia($request, Input::get('mediaid'))['data'];

	foreach($like as $key => $value) {
		$likes[] = $value['username'];
	}

	if(@$likes){
		$response = $telegram->sendMessage([
			'chat_id' => '@instatotelegram', 
			'text' => "👍 Liked By:".implode(",", $likes)
		]);
	}


	return redirect()->back();
});	