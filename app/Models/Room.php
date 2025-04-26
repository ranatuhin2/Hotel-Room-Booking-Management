<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'type',
        'price',
        'status',
    ];


    public function bookings()
    {
        return $this->hasMany(Booking::class,'room_id');
    }
}
