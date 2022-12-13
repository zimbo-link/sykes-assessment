<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;

    protected $fillable = [
        "start_date",
        "end_date"
    ];
 
    public function property()
    { 
        return $this->belongsTo('Properties');
    }
}
