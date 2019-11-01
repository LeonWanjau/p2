<?php

use App\Http\Controllers\Project\General\Users\ViewUsersController;
use GuzzleHttp\Client;
use AfricasTalking\SDK\AfricasTalking;

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
    return view('project_views.authentication_views.verify_user');
});

Route::get('test_fn', function () {
    /*
    $country_code = "+254";
    $phone_no = '0705678781';
    return $country_code.ltrim($phone_no,$phone_no[0]);
    */
    //$trimmed_no = "0".preg_replace("/^\+?{$country_code}/", '', $phone_no);
    //return $trimmed_no;

    $username = "sandbox";
        $api_key = "dd86d544f4930a538f1df27d523b92b250d53427b65b832af80ffe73ca019d04";

        $AT = new AfricasTalking($username, $api_key);

        $sms = $AT->sms();

        $from = "54544";

        try {

            $result = $sms->send([
                'to'      => '+254705678722',
                'message' => 'hello',
                'from'    => $from
            ]);
        } catch (Exception $e) {

            echo "Error: " . $e->getMessage();
        }
});

Route::post('test', function () {
    Log::channel('single')->info(Request::all());
    return " ";
});

Route::get('test_recurring', 'Project\Teachers\ScheduleController@test');

Route::get('data', 'Project\Teachers\ScheduleController@index')->name('temp');
Route::post('data', 'Project\Teachers\ScheduleController@store')->name('temp.store');
Route::put('data/{event_id}', 'Project\Teachers\ScheduleController@update')->name('temp.update');
Route::delete('data/{event_id}', 'Project\Teachers\ScheduleController@destroy')->name('temp.delete');

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
    Route::name('verification.')->middleware('auth')->group(function () {
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

    /*Verify User*/
    Route::name('verification.')->group(function() {
        Route::get('user/verify','VerifyUserController@showVerifyUserPage')->name('user.show');
        Route::get('user/redirect','VerifyUserController@redirectUser')->name('user.redirect');
    });
});

Route::namespace('Project\General')->group(function () {
    Route::name('home.')/*->middleware('verified')*/->group(function () {
        Route::get('home', 'HomeController@show')->name('show');
    });
});

//Users
/*
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
*/

//New Users
Route::namespace('Project\Users')/*->middleware(['auth','verified'])*/->group(function () {
    Route::prefix('users')->group(function () {
        //View Users
        Route::get('{user_type}/view', 'UsersController@showView')->name('users.view');
        //Return All Users
        Route::post('{user_type}/view','UsersController@returnAllUsers')->name('users.view');
        //User action
        Route::post('{user_type}/action','UsersController@action')->name('users.action');
        //Verify user
        Route::post('{user_type}/verify','UsersController@verifyUser')->name('users.verify');
        //Unverify user
        Route::post('{user_type}/unverify','UsersController@unverifyUser')->name('users.unverify');
    });
});

//Account
Route::namespace('Project\Account')->group(function () {
    Route::prefix('account')->group(function () {
        Route::get('view', 'AccountController@showViewAccount')->name('account.view');
        Route::get('edit', 'AccountController@showEditAccount')->name('account.edit.show');
        Route::post('edit', 'AccountController@editAccount')->name('account.edit');
    });
});

//Parents
Route::namespace('Project\Parents')->group(function () {
    Route::prefix('parents')->group(function () {
        Route::get('view', 'ParentsController@viewParents')->name('parents.view');
        //Route::get('add','ParentsController@showAddParent')->name('parents.add.show');
        Route::post('view', 'ParentsController@returnAllParents')->name('parents.view');
        //Route::post('edit','ParentsController@editParent')->name('parents.edit');
        //Route::post('add','ParentsController@addParent')->name('parents.add');
        Route::post('action', 'ParentsController@action')->name('parents.action');
    });
});

//Students
Route::namespace('Project\Students')->group(function () {

    //Students
    Route::prefix('students')->group(function () {
        /*Show view students page*/
        Route::get('view', 'StudentsController@showViewStudents')->name('students.view');
        /*Return all students*/
        Route::post('view', 'StudentsController@returnAllStudents')->name('students.view');
        /*Student CRUD*/
        Route::post('action', 'StudentsController@action')->name('students.action');
    });

    //Classes
    Route::prefix('classes')->group(function () {
        /*Show view classes page*/
        Route::get('view', 'ClassesController@showViewClasses')->name('classes.view');
        /*Return all classes*/
        Route::post('view', 'ClassesController@returnAllClasses')->name('classes.view');
        /*Classes CRUD*/
        Route::post('action', 'ClassesController@action')->name('classes.action');
        /*Return class name*/
        Route::post('class_name', 'ClassesController@returnClassName')->name('classes.name');
    });
});

//Teachers
Route::namespace('Project\Teachers')->group(function () {

    //Schedule
    Route::prefix('schedule')->middleware(['verified','verify.user'])->group(function () {
        //Show schedule
        Route::get('view', 'ScheduleController@showViewSchedule')->name('schedule.view');

        Route::get('data', 'ScheduleController@index')->name('schedule.load');
        Route::post('data', 'ScheduleController@store')->name('schedule.store');
        Route::put('data/{event_id}', 'ScheduleController@update')->name('schedule.update');
        Route::delete('data/{event_id}', 'ScheduleController@destroy')->name('schedule.delete');
    });
});

//Messages
Route::namespace('Project\Messages')->group(function () {

    //Handle messages
    Route::prefix('messages')->group(function () {
        //Receive message
        Route::get('receive', 'HandleMessagesController@receiveMessage')->name('messages.receive');
        Route::post('receive', 'HandleMessagesController@receiveMessage')->name('messages.receive');

        //Show parents messages received
        Route::get('/parents/received/view', 'ParentsMessagesReceivedController@showViewParentsMessagesReceived')->name('messages.parents.received.show');
        //Return all messages received from parents
        Route::post('/parents/received/view','ParentsMessagesReceivedController@returnAllReceivedMessages')->name('messages.parents.received.show');
        //Received parents messages action
        Route::post('/parents/received/action','ParentsMessagesReceivedController@action')->name('messages.parents.received.action');

        //Show parents messages sent
        Route::get('/parents/sent/view','ParentsMessagesSentController@showViewParentsMessagesSent')->name('messages.parents.sent.show');
        //Return all messages sent to parents
        Route::post('/parents/sent/view','ParentsMessagesSentController@returnAllSentMessages')->name('messages.parents.sent.show');
        //Sent parents messages action
        Route::post('/parents/sent/action','ParentsMessagesSentController@action')->name('messages.parents.sent.action');
        //Return all parents associated with a particular message
        Route::post('/parents/sent/associated_parents','ParentsMessagesSentController@returnParentsToMessages')->name('messages.parents.sent.associated');
   
        //Show teachers messages sent
        Route::get('/teachers/sent/view','TeachersMessagesSentController@showViewTeachersMessagesSent')->name('messages.teachers.sent.show');
        //Return all messages sent to teachers
        Route::post('/teachers/sent/view','TeachersMessagesSentController@returnAllMessages')->name('messages.teachers.sent.show');
        //Sent teacher messages action
        Route::post('/teachers/sent/action','TeachersMessagesSentController@action')->name('messages.teachers.sent.action');
        //Return all teachers associated with a particular message
        Route::post('/teachers/sent/associated_teachers','TeachersMessagesSentController@returnTeachersToMessages')->name('messages.teachers.sent.associated');
    });
});
