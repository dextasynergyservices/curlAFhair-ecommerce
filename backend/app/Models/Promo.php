<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'name',
        'phone',
        'promo_code',
        'wants_newsletter',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
