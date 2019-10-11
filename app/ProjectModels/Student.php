<?php
namespace App\ProjectModels;

use Illuminate\Database\Eloquent\Model;

class Student extends Model{
    
    public $timestamps=false;
    public $table="students";

    public function student_class(){
        return $this->belongsTo('App\ProjectModels\StudentClass','class_id');
    }

    public function parents(){
        return $this->belongsToMany('App\ProjectModels\StudentParent','parents_students','student_id','parent_id');
    }
}