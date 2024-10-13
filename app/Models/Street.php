<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'ward_id'];

    // Relationships
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function userLocations()
    {
        return $this->hasMany(UserLocation::class);
    }

    public function agentDetails()
    {
        return $this->hasMany(UserLocation::class);
    }
}
