<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    use HasFactory;

    protected $fillable=['job_name'];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class);
    }
    public function parttimers(): BelongsToMany
    {
        return $this->belongsToMany(Parttimer::class);
    }
}
