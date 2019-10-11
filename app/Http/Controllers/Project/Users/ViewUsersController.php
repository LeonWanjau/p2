<?php

namespace App\Http\Controllers\Project\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ViewUsersController extends Controller
{

    public function __construct()
    {
        /*
        $this->middleware('auth');
        $this->middleware('preventBackHistory');
        $this->middleware('verified');
        */ }

    public function showViewUsers($user_type)
    {
        if ($user_type == 'teachers') {
            $users = DB::table('users')->get();

            return view('project_views.users.view_users', ['users' => $users, 'user_type' => $user_type]);
        }
    }

    public function search(Request $request, $user_type)
    {
        if ($user_type == "teachers") {
            if ($request['search_value'] != null) {
                $search_values = explode(" ", $request['search_value']);

                $users = DB::table('users');

                foreach ($search_values as $search_value) {
                    $users = $users->where(function ($query) use ($search_value) {
                        $query->where('id', '=', $search_value)
                            ->orWhere('f_name', 'like', '%' . $search_value . '%')
                            ->orWhere('l_name', 'like', '%' . $search_value . '%')
                            ->orWhere('email', 'like', '%' . $search_value . '%')
                            ->orWhere('phone_number', 'like', '%' . $search_value . '%')
                            ->where('role_id', '=', 1);
                    });
                }

                $request->flash();

                $users = $users->get();

                return view('project_views.users.view_users', ['users' => $users, 'user_type' => $user_type]);
            } else {
                $request->flash();
                $users = DB::table('users')->get();
                return view('project_views.users.view_users', ['users' => $users, 'user_type' => $user_type]);
            }
        }


        /*
        $search_value = ($request['search_value'] ?? "");

        if ($user_type == 'teachers') {
            $users = DB::table('users')
                ->where('id', '=', $search_value)
                ->orWhere('f_name', 'like', '%' . $search_value . '%')
                ->orWhere('l_name', 'like', '%' . $search_value . '%')
                ->orWhere('email', 'like', '%' . $search_value . '%')
                ->orWhere('phone_number', 'like', '%' . $search_value . '%')
                ->where('role_id', '=', 1)
                ->get();

            $request->flash();
            
            return view('project_views.users.view_users',['users'=>$users,'user_type'=>$user_type]);
        }
        */
    }
}
