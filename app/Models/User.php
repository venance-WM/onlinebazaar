<?php

namespace App\Models;

use App\Events\CustomerRegistered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'role',
        'name',
        'email',
        'phone',
        'gender',
        'nida',
        'password',
        'status',
        'profile_photo_path',
    ];

    /**
     * The attributes that are pre-defined.
     *
     * @var array<int, string>
     */

    protected $attributes = [
        'role' => 3,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    //  App User roles
    const ROLE_ADMIN = 0;
    const ROLE_AGENT = 1;
    const ROLE_SELLER = 2;
    const ROLE_CUSTOMER = 3;


    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'seller_id');
    }

    public function orders()
    {
        // Customer role (assuming 'customer_id' foreign key)
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function location()
    {
        return $this->hasOne(UserLocation::class);
    }

    public function agentDetail()
    {
        return $this->hasOne(AgentDetail::class);
    }

    // notifications to seller
    protected $dispatchesEvents = [
        'created' => CustomerRegistered::class,
    ];

    //wishlist
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function sellerDetail()
    {
        return $this->hasOne(SellerDetail::class, 'user_id');
    }

    public function lipaAccounts()
    {
        return $this->hasMany(LipaAccount::class, 'user_id');
    }

    public function requests()
    {
        return $this->hasMany(SellerRequest::class, 'seller_id');
    }

    public function shopSubscriptions()
    {
        return $this->hasMany(ShopSubscription::class, 'customer_id');
    }

    public function subscribedShops()
    {
        return $this->belongsToMany(ShopSubscription::class, 'shop_subscriptions');
    }
}
