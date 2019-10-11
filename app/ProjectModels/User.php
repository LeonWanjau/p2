<?php
namespace App\ProjectModels;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail{

    use Notifiable;

    public $timestamps=false;

    protected $fillable=[
        'f_name','l_name','email','phone_number','role_id','password'
    ];

    protected $hidden=[
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userRole(){
        return $this->belongsTo('App\ProjectModels\UserRole','role_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    
}

?>