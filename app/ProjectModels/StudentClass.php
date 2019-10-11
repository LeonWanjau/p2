<?php

namespace App\ProjectModels;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{

    protected $table = "classes";
    public $timestamps = false;

    public function students()
    {
        return $this->hasMany('App\ProjectModels\Student','class_id');
    }
}
