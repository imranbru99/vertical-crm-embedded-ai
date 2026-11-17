<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\PipelineScore;
use Illuminate\Support\Carbon;

class ScoringAiService
{
    public function score(Deal $deal): PipelineScore
    {
        $stageProb = (float) ($deal->stage?->probability_pct ?? 20);
        $amountFactor = min(30, log10(max(1, (float) $deal->amount)) * 8);
        $recency = $deal->expected_close_date
            ? max(0, 25 - abs(Carbon::now()->diffInDays($deal->expected_close_date, false)))
            : 10;
        $activityBoost = min(15, $deal->activities()->count() * 3);
        $score = round(min(99, max(5, ($stageProb * 0.45) + $amountFactor + ($recency * 0.4) + $activityBoost)), 2);
        $confidence = round(min(95, 55 + ($activityBoost * 2) + ($stageProb * 0.2)), 2);

        $signals = [
            'stage_probability' => $stageProb,
            'amount_factor' => round($amountFactor, 2),
            'close_date_pressure' => round($recency, 2),
            'activity_boost' => $activityBoost,
            'vertical' => $deal->vertical,
        ];

        $summary = sprintf(
            'AI win probability %.0f%% for %s based on stage readiness, deal size, and engagement density.',
            $score,
            $deal->name
        );

        $record = PipelineScore::query()->create([
            'deal_id' => $deal->id,
            'score' => $score,
            'confidence' => $confidence,
            'model' => 'vertiq-score-v1',
            'signals' => $signals,
            'summary' => $summary,
            'scored_at' => now(),
        ]);

        $deal->update([
            'ai_score' => $score,
            'ai_score_rationale' => $summary,
        ]);

        return $record;
    }
}