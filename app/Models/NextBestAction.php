<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NextBestAction extends Model
{
    protected $fillable = [
        'deal_id', 'contact_id', 'assigned_to', 'action_type', 'title', 'rationale',
        'priority', 'impact_score', 'status', 'due_at', 'completed_at', 'meta',
    ];

    protected function casts(): array
    {
        return [
            'impact_score' => 'decimal:2',
            'due_at' => 'datetime',
            'completed_at' => 'datetime',
            'meta' => 'array',
        ];
    }

    public function deal(): BelongsTo
    {
        return $this->belongsTo(Deal::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}