<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'hours_allocated', 'hours_used', 'status',
        'started_at', 'renews_at', 'account_manager_id',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'renews_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function accountManager(): BelongsTo
    {
        return $this->belongsTo(StaffMember::class, 'account_manager_id');
    }

    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function hoursPercentUsed(): int
    {
        if ($this->hours_allocated <= 0) {
            return 0;
        }

        return (int) min(100, round(($this->hours_used / $this->hours_allocated) * 100));
    }
}
