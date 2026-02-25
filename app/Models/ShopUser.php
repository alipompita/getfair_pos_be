<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'user_id',
        'role',
    ];

    protected $casts = [
        'shop_id' => 'integer',
        'user_id' => 'integer',
        // role as enum: owner, manager, staff
        'role' => 'string',
    ];
}
