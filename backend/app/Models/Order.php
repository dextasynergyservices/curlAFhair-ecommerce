<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use HasFactory, LogsActivity;

    // Define the relationship: an Order belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

        // Define what should be logged
        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
                ->logAll() // Attributes to log
                ->useLogName('order') // Optional: custom log name
                ->logOnlyDirty() // Logs only changed values
                ->dontSubmitEmptyLogs() // Avoid logs if nothing changed
                ->setDescriptionForEvent(fn(string $eventName) => "has been {$eventName}");
        }
}
