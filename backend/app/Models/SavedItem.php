<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedItem extends Model
{
    Use HasFactory;

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
