<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function tovars()
    {
        return $this->belongsToMany(Tovar::class, 'cart_tovars');
    }
}
