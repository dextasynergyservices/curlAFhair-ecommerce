<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Define the relationship: an Order belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
