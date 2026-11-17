<?php

namespace App\Services;

use App\Models\Deal;
use App\Models\PipelineStage;

class PipelineService
{
    public function move(Deal $deal, PipelineStage $stage): Deal
    {
        $deal->update(['pipeline_stage_id' => $stage->id]);
        if ($stage->is_won) {
            $deal->update(['status' => 'won', 'forecast_category' => 'closed']);
        } elseif ($stage->is_lost) {
            $deal->update(['status' => 'lost', 'forecast_category' => 'omitted']);
        }

        return $deal->fresh(['stage']);
    }

    public function openPipelineValue(): float
    {
        return (float) Deal::query()->where('status', 'open')->sum('amount');
    }
}