<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\NextBestAction;

class NextBestActionService
{
    public function recommend(Deal $deal, ?int $assigneeId = null): NextBestAction
    {
        $type = match (true) {
            (float) ($deal->ai_score ?? 0) >= 80 => 'call',
            (float) ($deal->amount ?? 0) >= 50000 => 'proposal',
            default => 'email',
        };

        return NextBestAction::query()->create([
            'deal_id' => $deal->id,
            'contact_id' => $deal->contact_id,
            'assigned_to' => $assigneeId ?? $deal->owner_id,
            'action_type' => $type,
            'title' => ucfirst($type).' follow-up: '.$deal->name,
            'rationale' => 'Prioritized by Vertiq embedded AI using score, stage, and deal value.',
            'priority' => ((float) ($deal->ai_score ?? 0) >= 70) ? 'high' : 'medium',
            'impact_score' => round(((float) ($deal->ai_score ?? 50) + min(40, (float) $deal->amount / 5000)) / 2, 2),
            'status' => 'open',
            'due_at' => now()->addDays(2),
        ]);
    }
}