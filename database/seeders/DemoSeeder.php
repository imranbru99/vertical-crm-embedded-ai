<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Activity;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\PipelineStage;
use App\Models\RevenueWorkflow;
use App\Models\User;
use App\Models\VerticalField;
use App\Services\ActivityService;
use App\Services\ModuleManager;
use App\Services\NextBestActionService;
use App\Services\ScoringAiService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        app(ModuleManager::class)->syncFromConfig();

        $super = User::query()->updateOrCreate(
            ['email' => 'superadmin@vertiq.test'],
            ['name' => 'Super Admin', 'password' => Hash::make('password'), 'role' => UserRole::SuperAdmin, 'title' => 'Revenue Ops Director', 'is_active' => true]
        );
        User::query()->updateOrCreate(
            ['email' => 'admin@vertiq.test'],
            ['name' => 'CRM Admin', 'password' => Hash::make('password'), 'role' => UserRole::Admin, 'title' => 'Admin', 'is_active' => true]
        );
        $manager = User::query()->updateOrCreate(
            ['email' => 'manager@vertiq.test'],
            ['name' => 'Pipeline Manager', 'password' => Hash::make('password'), 'role' => UserRole::Manager, 'title' => 'Sales Manager', 'is_active' => true]
        );
        $staff = User::query()->updateOrCreate(
            ['email' => 'staff@vertiq.test'],
            ['name' => 'AE Staff', 'password' => Hash::make('password'), 'role' => UserRole::Staff, 'title' => 'Account Executive', 'is_active' => true]
        );
        User::query()->updateOrCreate(
            ['email' => 'demo@vertiq.test'],
            ['name' => 'Demo User', 'password' => Hash::make('password'), 'role' => UserRole::Demo, 'title' => 'Demo Seller', 'is_demo' => true, 'is_active' => true]
        );
        User::query()->updateOrCreate(
            ['email' => 'client@vertiq.test'],
            ['name' => 'Client Stakeholder', 'password' => Hash::make('password'), 'role' => UserRole::Client, 'title' => 'Buyer Portal', 'is_active' => true]
        );

        foreach ([
            ['name' => 'Prospect', 'slug' => 'prospect', 'position' => 1, 'probability_pct' => 10],
            ['name' => 'Qualified', 'slug' => 'qualified', 'position' => 2, 'probability_pct' => 30],
            ['name' => 'Proposal', 'slug' => 'proposal', 'position' => 3, 'probability_pct' => 55],
            ['name' => 'Negotiation', 'slug' => 'negotiation', 'position' => 4, 'probability_pct' => 75],
            ['name' => 'Won', 'slug' => 'won', 'position' => 5, 'probability_pct' => 100, 'is_won' => true],
            ['name' => 'Lost', 'slug' => 'lost', 'position' => 6, 'probability_pct' => 0, 'is_lost' => true],
        ] as $stage) {
            PipelineStage::query()->updateOrCreate(['slug' => $stage['slug']], $stage + ['color' => '#4F46E5']);
        }

        $dental = Company::query()->updateOrCreate(
            ['slug' => 'brightsmile-dental-group'],
            ['name' => 'BrightSmile Dental Group', 'industry' => 'Dental', 'city' => 'Austin', 'country' => 'US', 'annual_revenue' => 4200000, 'status' => 'active']
        );
        $legal = Company::query()->updateOrCreate(
            ['slug' => 'northstar-legal'],
            ['name' => 'Northstar Legal', 'industry' => 'Legal', 'city' => 'Chicago', 'country' => 'US', 'annual_revenue' => 9100000, 'status' => 'active']
        );
        $hvac = Company::query()->updateOrCreate(
            ['slug' => 'summit-hvac'],
            ['name' => 'Summit HVAC', 'industry' => 'HVAC', 'city' => 'Denver', 'country' => 'US', 'annual_revenue' => 2800000, 'status' => 'prospect']
        );

        $c1 = Contact::query()->updateOrCreate(
            ['email' => 'ops@brightsmile.test'],
            ['company_id' => $dental->id, 'owner_id' => $staff->id, 'first_name' => 'Ava', 'last_name' => 'Chen', 'title' => 'COO', 'lifecycle_stage' => 'sql', 'vertical' => 'Dental', 'status' => 'active']
        );
        $c2 = Contact::query()->updateOrCreate(
            ['email' => 'intake@northstar.test'],
            ['company_id' => $legal->id, 'owner_id' => $manager->id, 'first_name' => 'Jordan', 'last_name' => 'Lee', 'title' => 'Managing Partner', 'lifecycle_stage' => 'mql', 'vertical' => 'Legal', 'status' => 'active']
        );
        $c3 = Contact::query()->updateOrCreate(
            ['email' => 'dispatch@summit.test'],
            ['company_id' => $hvac->id, 'owner_id' => $staff->id, 'first_name' => 'Sam', 'last_name' => 'Rivera', 'title' => 'Owner', 'lifecycle_stage' => 'lead', 'vertical' => 'HVAC', 'status' => 'active']
        );

        $proposal = PipelineStage::query()->where('slug', 'proposal')->first();
        $qualified = PipelineStage::query()->where('slug', 'qualified')->first();
        $negotiation = PipelineStage::query()->where('slug', 'negotiation')->first();

        $d1 = Deal::query()->updateOrCreate(
            ['slug' => 'brightsmile-enterprise-renewal'],
            ['name' => 'BrightSmile Enterprise Renewal', 'company_id' => $dental->id, 'contact_id' => $c1->id, 'owner_id' => $staff->id, 'pipeline_stage_id' => $proposal->id, 'amount' => 86000, 'currency' => 'USD', 'expected_close_date' => now()->addDays(18), 'vertical' => 'Dental', 'status' => 'open', 'forecast_category' => 'commit']
        );
        $d2 = Deal::query()->updateOrCreate(
            ['slug' => 'northstar-intake-platform'],
            ['name' => 'Northstar Intake Platform', 'company_id' => $legal->id, 'contact_id' => $c2->id, 'owner_id' => $manager->id, 'pipeline_stage_id' => $negotiation->id, 'amount' => 124000, 'currency' => 'USD', 'expected_close_date' => now()->addDays(9), 'vertical' => 'Legal', 'status' => 'open', 'forecast_category' => 'best_case']
        );
        $d3 = Deal::query()->updateOrCreate(
            ['slug' => 'summit-service-zone-crm'],
            ['name' => 'Summit Service-Zone CRM', 'company_id' => $hvac->id, 'contact_id' => $c3->id, 'owner_id' => $staff->id, 'pipeline_stage_id' => $qualified->id, 'amount' => 42000, 'currency' => 'USD', 'expected_close_date' => now()->addDays(35), 'vertical' => 'HVAC', 'status' => 'open', 'forecast_category' => 'pipeline']
        );

        app(ActivityService::class)->log(['user_id' => $staff->id, 'deal_id' => $d1->id, 'contact_id' => $c1->id, 'type' => 'call', 'subject' => 'Renewal discovery', 'body' => 'Mapped chair utilization KPIs.', 'duration_minutes' => 32]);
        app(ActivityService::class)->log(['user_id' => $manager->id, 'deal_id' => $d2->id, 'contact_id' => $c2->id, 'type' => 'meeting', 'subject' => 'Partner demo', 'body' => 'Walked practice-area intake fields.', 'duration_minutes' => 48]);

        $scoring = app(ScoringAiService::class);
        $nba = app(NextBestActionService::class);
        foreach ([$d1, $d2, $d3] as $deal) {
            $scoring->score($deal->fresh(['stage', 'activities']));
            $nba->recommend($deal->fresh(), $deal->owner_id);
        }

        VerticalField::query()->updateOrCreate(
            ['vertical' => 'Dental', 'entity_type' => 'deal', 'field_key' => 'chair_count'],
            ['label' => 'Chair Count', 'field_type' => 'number', 'is_required' => true, 'sort_order' => 1, 'is_active' => true]
        );
        VerticalField::query()->updateOrCreate(
            ['vertical' => 'Legal', 'entity_type' => 'deal', 'field_key' => 'practice_area'],
            ['label' => 'Practice Area', 'field_type' => 'select', 'options' => ['PI', 'Family', 'Corporate'], 'is_required' => true, 'sort_order' => 1, 'is_active' => true]
        );
        VerticalField::query()->updateOrCreate(
            ['vertical' => 'HVAC', 'entity_type' => 'deal', 'field_key' => 'service_zones'],
            ['label' => 'Service Zones', 'field_type' => 'text', 'is_required' => false, 'sort_order' => 1, 'is_active' => true]
        );

        RevenueWorkflow::query()->updateOrCreate(
            ['slug' => 'proposal-sla-nudge'],
            ['name' => 'Proposal SLA Nudge', 'trigger' => 'stage_enter', 'vertical' => 'Dental', 'steps' => ['notify_owner', 'create_nba', 'escalate_manager'], 'sla_hours' => 48, 'is_active' => true, 'runs_count' => 3, 'last_run_at' => now()->subDay()]
        );

        Activity::query()->count();
        unset($super);
    }
}