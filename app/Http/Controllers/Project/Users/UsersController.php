<?php

namespace App\Http\Controllers\Project\Users;

use App\Http\Controllers\Controller;
use App\ProjectModels\User;
use App\ProjectModels\StudentParent as StudentParent;
use App\Http\Requests\AddTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersController extends Controller
{

    public function showView($user_type)
    {

        if ($user_type == 'teachers') {

            return view('project_views.users.view_teachers');
        } else if ($user_type == 'admins') {

            return view('project_views.users.view_admins');
        }
    }

    public function returnAllUsers(Request $request, $user_type)
    {


        if (Auth::user() == null) {

            if ($user_type == 'teachers') {

                $users = User::where('role_id', 1)->get();
            } else if ($user_type == 'admins') {

                $users = User::where('role_id', 2)->get();
            }
        }else if(Auth::user() !=null){

            $user=Auth::user();
            if ($user_type == 'teachers') {

                $users = User::where('role_id', 1)->where('id','!=',$user->id)->get();
            } else if ($user_type == 'admins') {

                $users = User::where('role_id', 2)->where('id','!=',$user->id)->get();
            }
        }

        return response()->json([
            'data' => $users
        ]);
    }

    public function action(Request $request, $user_type)
    {
        if ($request['action'] == 'edit') {
            return $this->edit(array_values($request['data'])[0]);
        } else if ($request['action'] == 'create') {
            return $this->add(array_values($request['data'])[0], $user_type);
        } else if ($request['action'] == 'remove') {
            return $this->delete(array_values($request['data'])[0]);
        }
    }

    public function add($data, $user_type)
    {

        $rules = [
            'f_name' => 'required|min:3',
            'l_name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|numeric|unique:users,phone_number',
            'password' => 'required|min:6'
        ];

        $messages = [
            'f_name.required' => 'The first name must be at least 3 characters',
            'f_name.min' => 'The first name must be at least 3 characters',
            'l_name.required' => 'The last name must be at least 3 characters',
            'l_name.min' => 'The last name must be at least 3 characters'
        ];

        $validator = $this->makeValidator($data, $rules, $messages);

        if ($validator->fails()) {

            $errors = $validator->errors();
            $error_msgs = [];

            foreach ($rules as $key => $value) {
                if ($errors->first($key)) {
                    array_push($error_msgs, ['name' => $key, 'status' => $errors->first($key)]);
                }
            }

            return response()->json([
                'fieldErrors' => $error_msgs
            ]);
        } else {

            if ($user_type == 'teachers') {

                $role_id = 1;
            } else if ($user_type == 'admins') {

                $role_id = 2;
            }

            $user = new User();
            $user->f_name = $data['f_name'];
            $user->l_name = $data['l_name'];
            $user->password = Hash::make($data['password']);
            $user->email = $data['email'];
            $user->phone_number = $data['phone_number'];
            $user->role_id = $role_id;
            $user->email_verified_at = Carbon::now('Africa/Nairobi')->format("Y-m-d H:i:s");
            $user->user_verified_at = Carbon::now('Africa/Nairobi')->format("Y-m-d H:i:s");
            $user->save();

            return response()->json([
                'data' => [$user]
            ]);
        }
    }

    public function edit($data)
    {

        $rules = [
            'f_name' => 'required|min:3',
            'l_name' => 'required|min:3',
            'email' => 'required|email',
            'phone_number' => 'required|numeric'
        ];

        $messages = [
            'f_name.required' => 'The first name must be at least 3 characters',
            'f_name.min' => 'The first name must be at least 3 characters',
            'l_name.required' => 'The last name must be at least 3 characters',
            'l_name.min' => 'The last name must be at least 3 characters'
        ];

        $validator = $this->makeValidator($data, $rules, $messages);

        if ($validator->fails()) {

            $errors = $validator->errors();
            $error_msgs = [];

            foreach ($rules as $key => $value) {
                if ($errors->first($key)) {
                    array_push($error_msgs, ['name' => $key, 'status' => $errors->first($key)]);
                }
            }

            return response()->json([
                'fieldErrors' => $error_msgs
            ]);
        } else {

            $user = User::find($data['id']);

            $user->f_name = $data['f_name'];
            $user->l_name = $data['l_name'];
            $user->email = $data['email'];
            $user->phone_number = $data['phone_number'];
            $user->save();

            return response()->json([
                'data' => [$user]
            ]);
        }
    }

    public function delete($data)
    {
        $user = User::find($data['id']);
        $user->delete();

        return response()->json([]);
    }

    public function verifyUser(Request $request)
    {
        $data = $request['data'];

        $user = User::find($data['id']);

        if ($user->user_verified_at == null) {

            $user->user_verified_at = Carbon::now('Africa/Nairobi')->format("Y-m-d H:i:s");
            $user->save();
        }


        return response()->json([
            'data' => [$user]
        ]);
    }

    public function unverifyUser(Request $request)
    {
        $data = $request['data'];

        $user = User::find($data['id']);

        if ($user->user_verified_at !== null) {

            $user->user_verified_at = null;
            $user->save();
        }


        return response()->json([
            'data' => [$user]
        ]);
    }

    public function makeValidator($data, $rules, $messages = null)
    {
        if ($messages == null) {
            $validator = Validator::make($data, $rules);
        } else {
            $validator = Validator::make($data, $rules, $messages);
        }
        return $validator;
    }
}
