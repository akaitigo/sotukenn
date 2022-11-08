<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parttimer extends Model
{

    use HasFactory;

    protected $fillable = ['employee_id', 'parttimer_pass', 'parttimer_name'];

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
