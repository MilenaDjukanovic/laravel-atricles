<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/* Setup CORS */
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Get articles for a certain user
Route::get('/articles/{idUser}', 'App\Http\Controllers\ArticleController@index');
// Route::get('articles', 'app\Http\Controllers\ArticleController@index');

// List single article
Route::get('/article/{id}', 'App\Http\Controllers\ArticleController@show');

// Create new article
Route::post('/article', 'App\Http\Controllers\ArticleController@store'); 

//Update article
Route::put('/article2', 'App\Http\Controllers\ArticleController@store');

//Delete article
Route::delete('/article/{id}', 'App\Http\Controllers\ArticleController@destroy');

//Register user
Route::post('/register', 'App\Http\Controllers\UserController@store');

//Login user
Route::post('login', function (Request $request){
    if(auth()->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])){
        //Authentication passed...
        $user = auth()->user();
        $user->api_token = Str::random(60);
        $user->save();
        return $user;
    }

    return response()->json([
        'error' => 'Unauthentucates user',
        'code' => 401,
    ], 401);
});

//Logout user
Route::middleware('auth:api')->post('logout', function (Request $request){
    if(auth()->user()) {
        $user = auth()->user();
        $user->api_token = null; //clear api token
        $user->save();

        return response()->json([
            'message'=>'Thank you for using our application',
        ]);
    }

    return response()->json([
        'error' => 'Unable to logout user',
        'code' => 401,
    ], 401);
});