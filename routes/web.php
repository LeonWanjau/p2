<?php

use App\Http\Controllers\Project\General\Users\ViewUsersController;
use GuzzleHttp\Client;

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
});

Route::get('test', function () {
    //return redirect()->action('Project\Users\ViewUsersController@showViewUsers',['user_type'=>'teachers']);
    //return "goodbye";
    // return view('project_views.users.edit_users',['user_type'=>'teachers']);
    //return view('project_views.account.view_account');
    //return view('project_views.account.edit_account');
    return view('project_views.teachers.view_schedule');
});

Route::post('test', function () {
    Log::channel('single')->info(Request::all());
    return " ";
});

Route::get('data', 'Project\Teachers\ScheduleController@index')->name('temp');
Route::post('data','Project\Teachers\ScheduleController@store')->name('temp.store');
Route::put('data/{event_id}','Project\Teachers\ScheduleController@update')->name('temp.update');
Route::delete('data/{event_id}','Project\Teachers\ScheduleController@destroy')->name('temp.delete');

/*
Route::namespace('Project\Authentication')->group(function () {
    Route::get('/login','Auth@showLogin')->name('show_login');
    Route::post('/login','Auth@login')->name('login');
    Route::get('/create_account', 'Auth@showCreateAccount')->name('show_create_account');
    Route::post('/create_account', 'Auth@createAccount')->name('create_account');
    Route::get('/verify_account/{id}', 'Auth@verify')->name('verify_account');
    Route::get('/verification_notice', 'Auth@show')->name('verification_notice');
    Route::get('/verification_rescend','Auth@resend')->name('verification_rescend');
    Route::get('/logout','Auth@logout')->name('logout');
    Route::get('/show_send_password_reset_link','Auth@showPasswordResetLink')->name('show_send_password_reset_link');
    Route::get('/show_password_reset/{token}','Auth@showPasswordReset')->name('show_password_reset');
    Route::get('/show_password_reset_status','Auth@showPasswordResetStatus')->name('show_password_reset_status');
    Route::post('/send_password_reset_link','Auth@sendResetLinkEmail')->name('send_password_reset_link');
    Route::post('/reset_password','Auth@reset')->name('reset_password');
});
*/

Route::namespace('Project\Authentication')->group(function () {
    /*Create Account*/
    Route::name('create_account')->group(function () {
        Route::get('create_account', 'CreateAccountController@showCreateAccountForm')->name('.show');
        Route::post('create_account', 'CreateAccountController@createAccount');
    });

    /*Verify Email*/
    Route::name('verification.')->group(function () {
        Route::get('email/resend', 'VerificationController@resend')->name('resend');
        Route::get('email/verify/{id}', 'VerificationController@verify')->name('verify');
        Route::get('email/notify', 'VerificationController@showVerificationPage')->name('notify');
    });

    /*Login*/
    Route::get('login', 'LoginController@showLoginForm')->name('login.show');
    Route::post('login', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    /*Send Password Reset Link*/
    Route::name('password.')->group(function () {
        Route::get('password/request', 'ForgotPasswordController@showLinkRequestForm')->name('request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('email');
    });

    /*Reset Password*/
    Route::name('password.')->group(function () {
        Route::get('password/reset/{token}', 'ResetPasswordController@showPasswordResetForm')->name('reset');
        Route::post('password/update', 'ResetPasswordController@reset')->name('update');
    });
});

Route::namespace('Project\General')->group(function () {
    Route::name('home.')/*->middleware('verified')*/->group(function () {
        Route::get('home', 'HomeController@show')->name('show');
    });
});

Route::namespace('Project\Users')->group(function () {
    Route::prefix('users')->group(function () {
        //View Users
        Route::get('{user_type}/view', 'ViewUsersController@showViewUsers')->name('users.view');
        Route::post('{user_type}/view', 'ViewUsersController@search')->name('users.search');

        //Edit Users
        Route::get('{user_type}/{id}/edit', 'EditUsersController@showEditUsers')->name('users.edit.show');
        Route::post('{user_type}/{id}/edit', 'EditUsersController@editUser')->name('users.edit');

        //Delete Users
        Route::get('{user_type}/{id}/delete', 'DeleteUsersController@delete')->name('users.delete');
    });
});

Route::namespace('Project\Account')->group(function () {
    Route::prefix('account')->group(function () {
        Route::get('view', 'AccountController@showViewAccount')->name('account.view');
        Route::get('edit', 'AccountController@showEditAccount')->name('account.edit.show');
        Route::post('edit', 'AccountController@editAccount')->name('account.edit');
    });
});

Route::namespace('Project\Parents')->group(function () {
    Route::prefix('parents')->group(function () {
        Route::get('view','ParentsController@viewParents')->name('parents.view');
        Route::get('add','ParentsController@showAddParent')->name('parents.add.show');
        Route::post('add','ParentsController@addParent')->name('parents.add');
    });
});
