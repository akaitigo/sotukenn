<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeedShift extends Model
{
    use HasFactory;
    protected $table = 'needshift'; 
    public function stores()
    {
        return $this->belongsTo(Store::class);
    }
}
