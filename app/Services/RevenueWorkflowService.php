<?php

namespace App\Services;

use App\Models\RevenueWorkflow;

class RevenueWorkflowService
{
    public function run(RevenueWorkflow $workflow): RevenueWorkflow
    {
        $workflow->update([
            'runs_count' => $workflow->runs_count + 1,
            'last_run_at' => now(),
        ]);

        return $workflow->fresh();
    }
}