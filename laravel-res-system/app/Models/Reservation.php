<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function guests(){
        return $this->belongsToMany(Guest::class , 'guest_reservation');
    }

    public function user(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public function room(){
        return $this->belongsTo(Room::class , 'room_id');
    }
}
