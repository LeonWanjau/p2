<?php

namespace App\Http\Controllers\Project\Parents;

use App\Http\Controllers\Controller;
use App\ProjectModels\StudentParent as StudentParent;
use App\Http\Requests\AddTeacher;

class ParentsController extends Controller{

    public function viewParents(){
        $parents=StudentParent::all();

        return view('project_views.parents.view_parents',['parents'=>$parents]);
    }

    public function showAddParent(){
        return view('project_views.parents.add_parent');
    }

    public function addParent(AddTeacher $request){
        $parent=new StudentParent;

        $parent->f_name=$request['f_name'];
        $parent->l_name=$request['l_name'];
        $parent->role=$request['role'];
        $parent->phone_number=$request['phone_number'];
        $parent->save();
    }
}