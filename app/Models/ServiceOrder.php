<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'seller_id',
        'customer_id',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

   
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

   

}