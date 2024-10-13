<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    // Relationships
    public function districts()
    {
        return $this->hasMany(District::class);
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
