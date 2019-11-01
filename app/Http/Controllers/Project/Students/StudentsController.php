<?php

namespace App\Http\Controllers\Project\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProjectModels\Student;
use App\ProjectModels\StudentClass;
use App\ProjectModels\StudentParent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StudentsController extends Controller
{

    public function showViewStudents()
    {
        return view('project_views.students.view_students');
    }

    public function returnAllStudents(Request $request)
    {
        $students = DB::table('classes')
            ->join('students', 'students.class_id', '=', 'classes.id')
            ->select('students.*', 'classes.class_name')
            ->get();

        $classes = StudentClass::pluck('class_name');

        $fathers = StudentParent::where('role', 'father')->get();
        $mothers = StudentParent::where('role', 'mother')->get();

        return response()->json([
            'data' => $students,
            'class_names' => $classes,
            'fathers' => $fathers,
            'mothers' => $mothers
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

    public function edit($data)
    {
        $rules = [
            'f_name' => 'required|min:3',
            'l_name' => 'required|min:3',
            'age' => 'required|integer',
            'class_name' => 'present|exists:classes,class_name',
            'mother_id'=>'required_without:father_id',
            'father_id'=>'required_without:mother_id'
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
            $class = StudentClass::where('class_name', '=', $data['class_name'])->first();

            $student = Student::find($data['id']);

            $student->f_name = $data['f_name'];
            $student->l_name = $data['l_name'];
            $student->age = $data['age'];
            $student->class_id = $class->id;

            if($data['mother_id'] != null){
                $student->mother_id=$data['mother_id'];
            }
            if($data['father_id'] != null){
                $student->father_id=$data['father_id'];
            }

            $student->save();

            $data = DB::table('students')
                ->join('classes', 'classes.id', '=', 'students.class_id')
                ->where('students.id', $student->id)
                ->select('students.*', 'classes.class_name')
                ->get();

            return response()->json([
                "data" => $data
            ]);
        }
    }

    public function add($data)
    {
        $rules = [
            'f_name' => 'required|min:3',
            'l_name' => 'required|min:3',
            'age' => 'required|integer',
            'class_name' => 'present|exists:classes,class_name',
            'mother_id'=>'required_without:father_id',
            'father_id'=>'required_without:mother_id'
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
            $class = StudentClass::where('class_name', '=', $data['class_name'])->first();

            $student = new Student;

            $student->f_name = $data['f_name'];
            $student->l_name = $data['l_name'];
            $student->age = $data['age'];
            $student->class_id = $class->id;   

            if($data['mother_id'] != null){
                $student->mother_id=$data['mother_id'];
            }
            if($data['father_id'] != null){
                $student->father_id=$data['father_id'];
            }

            $student->save();

            $data = DB::table('students')
                ->join('classes', 'classes.id', '=', 'students.class_id')
                ->where('students.id', $student->id)
                ->select('students.*', 'classes.class_name')
                ->get();

            return response()->json([
                "data" => $data
            ]);
        }
    }

    public function delete($data)
    {
        $student = Student::find($data['id']);
        $student->delete();

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
