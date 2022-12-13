<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable=['name'];
    
    public function admin()
    {
        return $this->hasOne(Admin::class,'store_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function parttimmers()
    {
        return $this->hasMany(Parttimer::class);
    }

    public function notices()
    {
        return $this->hasMany(Notice::class);
    }
}
