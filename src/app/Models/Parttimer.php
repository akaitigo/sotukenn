<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Parttimer extends Authenticatable
{

    use HasFactory;

    protected $fillable = ['id', 'password', 'name'];

    public function Jobs()
    {
        return $this->belongsToMany(Job::class);
    }
    public function Statuses()
    {
        return $this->belongsToMany(Status::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
