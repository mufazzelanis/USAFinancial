<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRequest extends Model
{
    protected $fillable = [
        'user_id', 'subscription_id', 'title', 'type', 'description', 'status', 'priority',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public static function types(): array
    {
        return [
            'bookkeeping' => 'Bookkeeping',
            'accounting' => 'Accounting',
            'payroll' => 'Payroll',
            'vat' => 'VAT Returns',
            'reporting' => 'Management Reporting',
            'secretarial' => 'Company Secretarial',
            'consulting' => 'Financial Consulting',
            'general' => 'General',
        ];
    }

    public static function statuses(): array
    {
        return ['pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'cancelled' => 'Cancelled'];
    }
}
