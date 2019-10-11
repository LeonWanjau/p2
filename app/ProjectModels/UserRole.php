<?php
namespace App\ProjectModels;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model{

    public function users(){
        return $this->hasMany('App\ProjectModels\User','role_id');
    }

}