<?php

namespace App\ProjectModels;

use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model{

    public $timestamps=false;
    public $table="parents";

    public function students(){
        return $this->belongsToMany('App\ProjectModels\Student','parents_students','parent_id','student_id');
    }

}