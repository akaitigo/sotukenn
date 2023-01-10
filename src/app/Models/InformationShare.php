<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationShare extends Model
{
    use HasFactory;
    protected $table = 'informationshares'; 
    public function stores()
    {
        return $this->belongsTo(Store::class);
    }
}
