<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'text',
        'owned_by',
        'subscription_status',
        'is_active',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owned_by');
    }

    public function isSubscriptionActive()
    {
        return $this->subscription_status === 'active' && $this->subscription_expiry > now();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'shop_users')
            ->withPivot('role')
            ->withTimestamps();
    }

    public static function boot()
    {
        parent::boot();



        static::creating(function ($shop) {
            //    record authenticated user as owner of the shop
            if (auth('sanctum')->check()) {
                $shop->owned_by = auth('sanctum')->id();
                // create ShopUser record for the owner

            }
        });

        static::created(function ($shop) {
            // create ShopUser record for the owner
            ShopUser::create([
                'shop_id' => $shop->id,
                'user_id' => $shop->owned_by,
                'role' => 'owner',
            ]);
        });
    }
}
