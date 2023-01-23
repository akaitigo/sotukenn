<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPassword;

class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable =[
        'name','email','password','refresh_token','access_token','calendarId'
    ];

    protected $hidden = [
        'password','remember_token',
    ];



     // Override default reset password
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }


}
