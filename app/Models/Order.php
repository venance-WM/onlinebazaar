<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_amount',
        'status'
    ];

    // Defined the relationship with the User (Customer) model.
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Defined the relationship with the OrderItem model
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
   
    
}