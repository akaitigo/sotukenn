<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{

    use HasFactory;

    protected $fillable=['employee_name','employee_pass','company_id'];
    
    public function jobs(): Belongsto
    {
        return $this->belongsToMany(Job::class);
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function parttimers(): HasMany
    {
        return $this->hasMany(Parttimer::class);
    }
    
    
}
