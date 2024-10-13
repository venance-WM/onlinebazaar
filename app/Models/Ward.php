<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'district_id'];

    // Relationships
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function streets()
    {
        return $this->hasMany(Street::class);
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
