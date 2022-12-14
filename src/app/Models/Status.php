<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    use HasFactory;
    
    protected $fillable=['name'];
    
    public function Parttimers()
    {
        return $this->belongsToMany(Parttimer::class);
    }
    public function Employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}
