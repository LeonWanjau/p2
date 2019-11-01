<?php

namespace App\Http\Controllers\Project\Parents;

use App\Http\Controllers\Controller;
use App\ProjectModels\StudentParent as StudentParent;
use App\Http\Requests\AddTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ParentsController extends Controller
{

    public function viewParents()
    {
        return view('project_views.parents.view_parents');
    }

    public function returnAllParents()
    {
        $parents = StudentParent::all();

        return response()->json([
            'data' => $parents
        ]);
    }

    public function action(Request $request)
    {
        if ($request['action'] == 'edit') {
            return ($this->editParent($request));
        } else if ($request['action'] == 'create') {
            return ($this->addParent($request));
        } else if($request['action']=='remove'){
            return ($this->delete($request));
        }
    }

    public function editParent($request)
    {
        $rules = [
            'f_name' => 'required|min:3',
            'l_name' => 'required|min:3',
            'phone_number' => 'required|numeric',
            'role' => 'required|present'
        ];

        $messages = [
            'f_name.required' => 'The first name must be at least 3 characters',
            'f_name.min' => 'The first name must be at least 3 characters',
            'l_name.required' => 'The last name must be at least 3 characters',
            'l_name.min' => 'The last name must be at least 3 characters'
        ];

        $data = array_values($request['data'])[0];

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
            $parent = StudentParent::find($data['id']);

            $parent->f_name = $data['f_name'];
            $parent->l_name = $data['l_name'];
            $parent->phone_number = $data['phone_number'];
            $parent->role = $data['role'];

            $parent->save();

            return response()->json([
                "data" => [$parent]
            ]);
        }
    }

    public function showAddParent()
    {
        return view('project_views.parents.add_parent');
    }

    public function addParent($request)
    {
        $rules = [
            'f_name' => 'required|min:3',
            'l_name' => 'required|min:3',
            'phone_number' => 'required|numeric',
            'role' => 'required|present'
        ];

        $messages = [
            'f_name.required' => 'The first name must be at least 3 characters',
            'f_name.min' => 'The first name must be at least 3 characters',
            'l_name.required' => 'The last name must be at least 3 characters',
            'l_name.min' => 'The last name must be at least 3 characters'
        ];

        $data = array_values($request['data'])[0];

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
            $parent = new StudentParent;

            $parent->f_name = $data['f_name'];
            $parent->l_name = $data['l_name'];
            $parent->phone_number = $data['phone_number'];
            $parent->role = $data['role'];

            $parent->save();

            return response()->json([
                "data" => [$parent]
            ]);
        }
    }

    public function delete($request){
        $data = array_values($request['data'])[0];

        $parent=StudentParent::find($data['id']);
        $parent->delete();

        return response()->json([]);
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
