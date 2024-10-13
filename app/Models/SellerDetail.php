<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellerDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'region_id',
        'district_id',
        'ward_id',
        'street_id',
        'zone',
        'business_type',
        'business_name',
        'trading_name',
        'sector_of_shop',
        'whatsapp_number',
        'latitude',
        'longitude',
        'shop_image_one',
        'shop_image_two',
        'shop_image_three',
    ];

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
