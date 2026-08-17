<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'company', 'plan_id', 'hourly_service_id',
        'message', 'status', 'source', 'admin_notes',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function hourlyService(): BelongsTo
    {
        return $this->belongsTo(HourlyService::class);
    }

    public static function statuses(): array
    {
        return ['new' => 'New', 'contacted' => 'Contacted', 'converted' => 'Converted', 'closed' => 'Closed'];
    }
}
