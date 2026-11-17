<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevenueWorkflow extends Model
{
    protected $fillable = [
        'name', 'slug', 'trigger', 'vertical', 'steps', 'sla_hours',
        'is_active', 'runs_count', 'last_run_at', 'meta',
    ];

    protected function casts(): array
    {
        return [
            'steps' => 'array',
            'is_active' => 'boolean',
            'last_run_at' => 'datetime',
            'meta' => 'array',
        ];
    }
}