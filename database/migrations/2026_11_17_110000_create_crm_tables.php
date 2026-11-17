<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('industry')->nullable();
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('status')->default('active');
            $table->decimal('annual_revenue', 14, 2)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('title')->nullable();
            $table->string('lifecycle_stage')->default('lead');
            $table->string('vertical')->nullable();
            $table->string('source')->nullable();
            $table->string('status')->default('active');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('pipeline_stages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('position')->default(0);
            $table->unsignedInteger('probability_pct')->default(0);
            $table->boolean('is_won')->default(false);
            $table->boolean('is_lost')->default(false);
            $table->string('color')->default('#4F46E5');
            $table->timestamps();
        });

        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('pipeline_stage_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->decimal('amount', 14, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->date('expected_close_date')->nullable();
            $table->string('vertical')->nullable();
            $table->string('status')->default('open');
            $table->decimal('ai_score', 5, 2)->nullable();
            $table->text('ai_score_rationale')->nullable();
            $table->string('forecast_category')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('pipeline_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained()->cascadeOnDelete();
            $table->decimal('score', 5, 2);
            $table->decimal('confidence', 5, 2)->default(0);
            $table->string('model')->default('vertiq-score-v1');
            $table->json('signals')->nullable();
            $table->text('summary')->nullable();
            $table->timestamp('scored_at')->nullable();
            $table->timestamps();
        });

        Schema::create('next_best_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action_type')->default('task');
            $table->string('title');
            $table->text('rationale')->nullable();
            $table->string('priority')->default('medium');
            $table->decimal('impact_score', 5, 2)->default(0);
            $table->string('status')->default('open');
            $table->timestamp('due_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('vertical_fields', function (Blueprint $table) {
            $table->id();
            $table->string('vertical');
            $table->string('entity_type')->default('deal');
            $table->string('field_key');
            $table->string('label');
            $table->string('field_type')->default('text');
            $table->json('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['vertical', 'entity_type', 'field_key']);
        });

        Schema::create('revenue_workflows', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('trigger')->default('stage_enter');
            $table->string('vertical')->nullable();
            $table->json('steps')->nullable();
            $table->unsignedInteger('sla_hours')->default(24);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('runs_count')->default(0);
            $table->timestamp('last_run_at')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('deal_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('contact_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('note');
            $table->string('subject');
            $table->text('body')->nullable();
            $table->timestamp('occurred_at')->nullable();
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
        Schema::dropIfExists('revenue_workflows');
        Schema::dropIfExists('vertical_fields');
        Schema::dropIfExists('next_best_actions');
        Schema::dropIfExists('pipeline_scores');
        Schema::dropIfExists('deals');
        Schema::dropIfExists('pipeline_stages');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('companies');
    }
};