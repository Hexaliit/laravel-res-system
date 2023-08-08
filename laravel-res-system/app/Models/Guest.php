<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function reservations(){
        return $this->belongsToMany(Reservation::class , 'guest_reservation');
    }
}
