<?php

namespace Tests\Feature;

use App\Services\ModuleManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModuleToggleTest extends TestCase
{
    use RefreshDatabase;

    public function test_modules_can_be_toggled(): void
    {
        $manager = app(ModuleManager::class);
        $manager->toggle('scoring_ai', false);
        $this->assertFalse($manager->enabled('scoring_ai'));
        $this->assertDatabaseHas('module_settings', ['key' => 'scoring_ai', 'enabled' => 0]);
    }
}