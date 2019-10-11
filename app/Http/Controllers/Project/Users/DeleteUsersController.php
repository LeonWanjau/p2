<?php

namespace App\Http\Controllers\Project\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteUsersController extends Controller{

    public function delete(Request $request,$user_type,$id){
        if($user_type=='teachers'){
            DB::table('users')->where('id','=',$id)->delete();

            $request->session()->flash('custom_status','The user has been deleted');

            return redirect(route('users.view',['user_type'=>$user_type]));
        }
    }
}