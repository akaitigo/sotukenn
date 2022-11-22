<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\EmployeeResetPassword;

class Employee extends Authenticatable
{

    use HasFactory;
    use Notifiable;

    protected $guard = 'employee';

    protected $fillable =[
        'name','email','password',
    ];

    protected $hidden = [
        'password','remember_token',
    ];
    
    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }
    public function stores(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
    public function parttimers(): HasMany
    {
        return $this->hasMany(Parttimer::class);
    }
    
    // Override default reset password
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new EmployeeResetPassword($token));
    }
    
}
