<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
       'agent_id', 'seller_id', 'category_id', 'name', 'description', 'price', 'image', 'stock_quantity', 'unit_id'
    ];

    /**
     * Get the category that owns the product.
     */

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
   
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function unit()
{
    return $this->belongsTo(Unit::class);
}

public function reviews()
{
    return $this->hasMany(Review::class);
}


}