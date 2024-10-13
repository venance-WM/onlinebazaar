<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'region_id'];

    // Relationships
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function wards()
    {
        return $this->hasMany(Ward::class);
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
