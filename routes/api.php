 <?php

use Illuminate\Http\Request;

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
Route::group(['prefix' => 'search'], function() {
    Route::get('/', array('middleware' => 'cors', 'uses' => 'SearchController@index'));
    Route::get('/userFields', array('middleware' => 'cors', 'uses' => 'SearchController@userFields'));
    Route::post('/filteredUsers', array('middleware' => 'cors', 'uses' => 'SearchController@filteredUsers'));
    
    // Route::get('/', 'SearchController@index')->name('search');
    // Route::get('/{post}', 'PostController@show')->name('posts.show');
    // Route::post('/', 'PostController@store')->name('posts.store');
    // Route::put('/{post}', 'PostController@update')->name('posts.update');
    // Route::delete('/{post}', 'PostController@delete')->name('posts.delete');
});
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
