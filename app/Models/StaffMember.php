<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaffMember extends Model
{
    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'role_title', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'account_manager_id');
    }

    public static function roleTitles(): array
    {
        return [
            'accountant' => 'Accountant',
            'bookkeeper' => 'Bookkeeper',
            'payroll_associate' => 'Payroll Associate',
        ];
    }
}
