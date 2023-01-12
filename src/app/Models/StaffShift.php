<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffShift extends Model
{
    use HasFactory;
    protected $table = 'staffshift'; 
    public function stores()
    {
        return $this->belongsTo(Store::class);
    }
}
