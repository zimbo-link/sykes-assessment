<?php

namespace App\Models;

use App\Models\Bookings;
use App\Models\Locations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Properties extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "property_name",
        "near_beach",
        "accepts_pets",
        "sleeps",
        "beds"
    ];

    public function location()
    {
        return $this->hasOne(Locations::class, 'id', 'location_id');
    }

    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'property_id', 'id');
    }
}