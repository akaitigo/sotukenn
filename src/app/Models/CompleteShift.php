<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompleteShift extends Model
{
    use HasFactory;
    protected $table = 'complete_shifts';

    public function stores()
    {
        return $this->belongsTo(Store::class);
    }
}
