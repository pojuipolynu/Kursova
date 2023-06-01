<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tovar extends Model
{
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }
    public function weight()
    {
        return $this->belongsTo(Weight::class, 'weight_id', 'id');
    }
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'cart_tovars');
    }

}
