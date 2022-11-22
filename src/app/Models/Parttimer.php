<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ParttimerResetPassword;

class Parttimer extends Authenticatable
{

    use HasFactory;
    use Notifiable;

    protected $guard = 'parttimer';

    protected $fillable =[
        'name','email','password',
    ];

    protected $hidden = [
        'password','remember_token',
    ];

    public function Jobs()
    {
        return $this->belongsToMany(Job::class,'parttimer_job');
    }
    public function Statuses()
    {
        return $this->belongsToMany(Status::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function stores(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

     // Override default reset password
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ParttimerResetPassword($token));
    }
}
