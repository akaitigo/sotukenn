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

    public function shiftdivider()
    {
        return $this->hasMany(Shiftdivider::class);
    }

    public function informations()
    {
        return $this->hasMany(Information::class);
    }

    public function completeshift()
    {
        return $this->hasMany(CompleteShift::class);
    }

    public function staffshift()
    {
        return $this->hasMany(StaffShift::class);
    }

    public function nextdivider()
    {
        return $this->hasMany(Nextdivider::class);
    }

    public function needshift()
    {
        return $this->hasMany(NeedShift::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
}
