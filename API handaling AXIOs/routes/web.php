<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/clearapp', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Session::flush();
    return redirect('/');
});


Route::group(['middleware' => ['guest', 'web']], function () {
    Route::get('/', 'AuthController@redirectToIndex');

    //react route
    Route::get('/login', 'AuthController@index')->name('Login');
    Route::get('/registration', 'AuthController@index')->name('Registration');

    Route::post('/login', 'AuthController@login');
    Route::post('/registration', 'AuthController@signup');
});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', 'HomeController@logout')->name('Logout');
    Route::get('/home', 'HomeController@index')->name('Dashboard');
    
    //react route
    Route::get('/lead/list', 'LeadController@index')->name('Leads');
    Route::get('/lead/new', 'LeadController@index')->name('NewLead');
    Route::get('/lead/edit/{id}', 'LeadController@index')->name('EditLead');
    Route::get('/sendemail', 'MailController@index')->name('Sendemail');
    Route::post('/sendemail/send', 'MailController@send')->name('send');


});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
Route::get('/senedmail', [MailController::class,'index']);
Route::post('/senedmail/send',[MailController::class,'send']);

Route::get('email', function () {

    $user = [
        'name' => 'mahir',
        'info' => 'Laravel react js'
    ];

    Mail::to('mahirshahriar786@gmail.com')->send(new \App\Mail\NewMail($user));

    dd("success");

});