<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function tovar()
    {
        return $this->hasMany(Tovar::class, 'type_id', 'id');
    }
}
