<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    public function tovar()
    {
        return $this->hasMAny(Tovar::class, 'weight_id', 'id');
    }
}
