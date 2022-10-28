<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parttimer extends Model
{

    use HasFactory;
    
    protected $fillable=['employee_id','parttimer_pass','parttimer_name'];
    
    public function Jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class);
    }
    public function Statuses(): BelongsToMany
    {
        return $this->belongsToMany(Status::class);
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
