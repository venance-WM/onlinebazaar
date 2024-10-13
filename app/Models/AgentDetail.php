<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgentDetail extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

     protected $fillable = ['user_id', 'region_id', 'district_id', 'ward_id', 'street_id', 'place'];

     public function user()
     {
         return $this->belongsTo(User::class);
     }
 
     public function region()
     {
         return $this->belongsTo(Region::class);
     }
 
     public function district()
     {
         return $this->belongsTo(District::class);
     }
 
     public function ward()
     {
         return $this->belongsTo(Ward::class);
     }
 
     public function street()
     {
         return $this->belongsTo(Street::class);
     }
}
