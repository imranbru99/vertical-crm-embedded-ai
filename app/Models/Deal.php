<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deal extends Model
{
    protected $fillable = [
        'company_id', 'contact_id', 'owner_id', 'pipeline_stage_id', 'name', 'slug',
        'amount', 'currency', 'expected_close_date', 'vertical', 'status',
        'ai_score', 'ai_score_rationale', 'forecast_category', 'meta',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expected_close_date' => 'date',
            'ai_score' => 'decimal:2',
            'meta' => 'array',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(PipelineStage::class, 'pipeline_stage_id');
    }

    public function scores(): HasMany
    {
        return $this->hasMany(PipelineScore::class);
    }

    public function nextBestActions(): HasMany
    {
        return $this->hasMany(NextBestAction::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }
}