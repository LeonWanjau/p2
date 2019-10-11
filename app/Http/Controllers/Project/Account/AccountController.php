<?php

namespace App\Http\Controllers\Project\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditAccount;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{ 
    public function showViewAccount(){
        return view('project_views.account.view_account');
    }


    public function showEditAccount(){
        return view('project_views.account.edit_account');
    }

    public function editAccount(EditAccount $request){
        
        $user=Auth::user();

        $user->f_name=$request['f_name'];
        $user->l_name=$request['l_name'];
        $user->phone_number=$request['phone_number'];
        $user->email=$request['email'];
        $user->save();
        

        $request->session()->flash('custom_status','Your account details have been updated');

        return redirect(route('account.view'));
    }
}
