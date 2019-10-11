<?php
namespace App\Http\Controllers\Project\General;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory as View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller{

    public function __construct(){
       $this->middleware('auth');
       $this->middleware('preventBackHistory');
       $this->middleware('verified');
    }

    public function show(View $view){
        //return $view->make('project_views.general.home');
        return redirect(route('users.teachers.view'));
    }
}