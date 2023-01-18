<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nextdivider extends Model
{
    use HasFactory;
    protected $table = 'nextdivider';

    public function stores()
    {
        return $this->belongsTo(Store::class);
    }
}
