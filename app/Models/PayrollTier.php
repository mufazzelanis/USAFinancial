<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollTier extends Model
{
    protected $fillable = [
        'name', 'employee_limit', 'price', 'currency', 'features', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'is_active' => 'boolean',
            'price' => 'decimal:2',
        ];
    }
}
