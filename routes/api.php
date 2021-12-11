<?php

use App\Http\Controllers\Front\MediaController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Gestion\GestionRedirectController;
use App\Http\Controllers\Gestion\ActuController;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\DB;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
// return $request->user();
//});

// _Protected Routes_____Protected Routes_______Protected Routes_______Protected Routes_

//Route::group(['middleware'=>['auth:sanctum']],function(){
//}
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Login route
    Route::post("/login",[AuthController::class,'login']);

    // Logout route
    Route::post("/logout",[AuthController::class,'logout']);

     // Adding route Medias
    Route::post('/add/media',[MediaController::class, 'store']);

     // Edit route Medias
    Route::get('/edit/media/{id}',[MediaController::class, 'show']);

    //  Update route media
    Route::post('/update/media/{id}',[MediaController::class, 'update']);

     // Delete route Medias
    Route::post('/destroy/media/{id}',[MediaController::class, 'destroy']);

    // Route Admin or SuperUser or Users
    Route::post("/admin",[GestionRedirectController::class,'loginAdmin']);

    // Adding route Actualité
    Route::post('/add/actu',[ActuController::class, 'store']);

     // Edit route Actualité
    Route::get('/edit/actu/{id}',[ActuController::class, 'show']);

    //  Update route Actualité
    Route::post('/update/actu/{id}',[ActuController::class, 'update']);

     // Delete route Actualité
    Route::post('/destroy/actu/{id}',[ActuController::class, 'destroy']);


});


// _____Public Routes_____Public Routes_______Public Routes_______Public Routes_

//Route::resource('media', MediaController::class);
 // Display route Media
Route::get('/media',[MediaController::class, 'index']);

 // Search route media
Route::get('/media/search/{texte}',[MediaController::class, 'search']);

 // Register route
Route::post('/register',[AuthController::class, 'register']);

// Category route
Route::get('/categorie/{id}',[PageController::class, 'voirCategorie']);

// Country route
Route::get('/pays/{id}',[PageController::class, 'country']);

// Display route Actu
Route::get('/actu',[ActuController::class, 'Actu']);
