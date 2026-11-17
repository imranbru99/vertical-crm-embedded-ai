<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Deal;
use App\Models\PipelineStage;
use App\Models\User;
use App\Services\ScoringAiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrmPipelineTest extends TestCase
{
    use RefreshDatabase;

    public function test_scoring_ai_assigns_win_probability(): void
    {
        $owner = User::factory()->create();
        $stage = PipelineStage::query()->create([
            'name' => 'Proposal', 'slug' => 'proposal', 'position' => 3, 'probability_pct' => 55, 'color' => '#4F46E5',
        ]);
        $company = Company::query()->create([
            'name' => 'Acme Verticals', 'slug' => 'acme-verticals', 'industry' => 'HVAC', 'status' => 'active',
        ]);
        $deal = Deal::query()->create([
            'name' => 'Acme Annual Retainer', 'slug' => 'acme-annual-retainer', 'company_id' => $company->id,
            'owner_id' => $owner->id, 'pipeline_stage_id' => $stage->id, 'amount' => 48000,
            'currency' => 'USD', 'forecast_category' => 'pipeline', 'status' => 'open',
        ]);

        $score = app(ScoringAiService::class)->score($deal);
        $this->assertGreaterThan(0, (float) $score->score);
        $this->assertDatabaseHas('pipeline_scores', ['deal_id' => $deal->id]);
    }
}