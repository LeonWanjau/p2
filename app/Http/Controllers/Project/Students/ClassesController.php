<?php

namespace App\Http\Controllers\Project\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProjectModels\User;
use App\ProjectModels\StudentClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{

    public function showViewClasses()
    {
        return view('project_views.students.view_classes');
    }

    public function returnAllClasses()
    {
        $teachers=User::where('role_id',1)->get();

        $classes = StudentClass::all();

        return response()->json([
            'data' => $classes,
            'teachers'=>$teachers
        ]);
    }

    public function action(Request $request)
    {
        if ($request['action'] == 'edit') {
            return $this->edit(array_values($request['data'])[0]);
        } else if ($request['action'] == 'create') {
            return $this->add(array_values($request['data'])[0]);
        } else if ($request['action'] == 'remove') {
            return $this->delete(array_values($request['data'])[0]);
        }
    }

    public function add($data)
    {
        $rules = [
            'class_name' => 'required|unique:classes,class_name',
            'teacher_id' => 'required|integer|exists:users,id',
            'number_of_students' => 'required|integer'
        ];


        $messages = [
            'class_name.required' => 'The class field is required',
            'teacher_id.required' => 'The class teacher ID field is required',
            'teacher_id.exists' => 'The teacher ID must be present in the system',
            'class_name.unique'=>'That class already exists'
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
            $class = new StudentClass;

            $class->class_name = $data['class_name'];
            $class->teacher_id = $data['teacher_id'];
            $class->number_of_students = $data['number_of_students'];

            $class->save();

            return response()->json([
                "data" => [$class]
            ]);
        }
    }

    public function edit($data)
    {
        $rules = [
            'class_name' => 'required',
            'teacher_id' => 'required|integer|exists:users,id',
            'number_of_students' => 'required|integer'
        ];


        $messages = [
            'class_name.required' => 'The class field is required',
            'teacher_id.required' => 'The class teacher ID field is required',
            'teacher_id.exists' => 'The teacher ID must be present in the system',
            'class_name.unique'=>'That class already exists'
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
            $class = StudentClass::find($data['id']);

            $class->class_name = $data['class_name'];
            $class->teacher_id = $data['teacher_id'];
            $class->number_of_students = $data['number_of_students'];

            $class->save();

            return response()->json([
                "data" => [$class]
            ]);
        }
    }

    public function delete($data){
        $class=StudentClass::find($data['id']);
        $class->delete();

        return response()->json([]);
    }

    public function returnClassName(Request $request){
        if($request['values']['class_id'] != null){
            $class_id=$request['values']['class_id'];

            $class_name=StudentClass::where('id','=',$class_id)->get()->pluck('class_name');/*->select('class_name')->get()*/;

            return response()->json([
                'values'=>['class_name'=>$class_name]
            ]);
        }else{
            return response()->json([
                'values'=>['class_name'=>""]
            ]);
        }
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
