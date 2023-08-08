<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function room_types()
    {
        return $this->hasMany(RoomType::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class , 'feature_hotel');
    }

}
