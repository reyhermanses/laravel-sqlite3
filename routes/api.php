<?php

use App\Book;
use Illuminate\Http\Request;
use App\Http\Middleware\IsAdmin;
use App\Http\Requests\PostBookReviewRequest;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users/register/', 'UserController@create');

Route::post('users/login', 'UserController@login');

Route::middleware(['auth:api'])->group(function () {
    Route::middleware(['auth.admin'])->group(function () {
    });
});
Route::get('/books', 'BooksController@index');
Route::post('/books', 'BooksController@store');
// Route::post('/books/{id}/reviews', function ($bookId, PostBookReviewRequest $request){
//     // return [$bookId, $request->review];

//     $validated = $request->validated();
//     $user = Book::find($bookId);

//     if (is_null($user)) {
//         return response()->json([
//             'status' => 'ERROR',
//             'error' => '404 not found'
//         ], 404);
//     }else{
//         return $user;
//     }
// });
Route::post('/books/{id}/reviews', 'BooksReviewController@store')->middleware(['auth.admin']);;
// Route::post('/books/{id}/reviews', 'BooksReviewController@store');
Route::delete('/books/{bookId}/reviews/{reviewId}', 'BooksReviewController@destroy');


Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@website.com'], 404);
})->name('api.fallback.404');