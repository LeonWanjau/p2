<?php

namespace App\Http\Controllers\Project\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EditUser;
use Illuminate\Support\Facades\DB;

class EditUsersController extends Controller
{

    public function showEditUsers(Request $request,$user_type, $id)
    {
        if($user_type=="teachers"){
        return view('project_views.users.edit_users', [
            'id' => $id,
            'f_name' => $request['f_name'],
            'l_name' => $request['l_name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'user_type'=>$user_type
        ]);
        }
    }

    public function editUser(EditUser $request, $user_type, $id)
    {
        if($user_type=="teachers"){
        $user = DB::table('users')->where('id', $id)->update([
            'f_name' => $request['f_name'],
            'l_name' => $request['l_name'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number']
        ]);

        $request->session()->flash('custom_status','The teacher\'s details have been updated');

        return redirect(route('users.view',['user_type'=>$user_type]));
        }
    }
}
