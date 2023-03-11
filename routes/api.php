<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/// GET POST PUT DELETE [posts]

// Route::get('posts',function(){
//     $posts = DB::table('posts')->get();
//     return response()->json([
//         'status' => 'success',
//         'data' => $posts
    
//     ]);
// });

// /// show post by id 
// Route::get('posts/{id}',function($id){
//     $post = DB::table('posts')->where('id',$id)->first();
//     return response()->json([
//         'status' => 'success',
//         'data' => $post
    
//     ]);
// });
// /// create post 
// Route::post('posts',function(){
//    $post =  DB::insert('insert into posts (fullname,gender, phone) values (?, ?, ?)', ['Joe','male','123456789']);
//     return response()->json([
//      'status' => 'success',
//      'data' => $post
//     ]);


// });

// /// update post
// Route::put('posts/{id}',function($id){
//     $post = DB::table('posts')->where('id',$id)->update(['fullname' => 'Joe']);
//     return response()->json([
//         'status' => 'success',
//         'data' => $post
    
//     ]);
// });

// /// delete post
// Route::delete('posts/{id}',function($id){
//     $post = DB::table('posts')->where('id',$id)->delete();
//     return response()->json([
//         'status' => 'success',
//         'data' => $post
    
//     ]);
// });


/// register user with passport
Route::post('register', [App\Http\Controllers\UserAuthController::class, 'register']);
/// login
Route::post('login', [App\Http\Controllers\UserAuthController::class, 'login']);

/// update user 
Route::post('user/update/{id}', [App\Http\Controllers\UserAuthController::class, 'update']);
/// get me 
Route::get('user/me', [App\Http\Controllers\UserAuthController::class, 'me'])->middleware('auth:api');

Route::post('logout', [App\Http\Controllers\UserAuthController::class, 'logout'])->middleware('auth:api');

Route::post('posts', [App\Http\Controllers\PostController::class, 'store'])->middleware('auth:api');