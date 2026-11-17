<?php

namespace Tests\Feature;

use Tests\TestCase;

class ModuleConfigTest extends TestCase
{
    public function test_modules_config_lists_crm_modules(): void
    {
        $modules = config('modules');
        $this->assertIsArray($modules);
        foreach (['contacts','deals','pipeline','scoring_ai','next_best_actions','vertical_fields','revenue_workflows','activities'] as $key) {
            $this->assertArrayHasKey($key, $modules);
        }
    }

    public function test_home_page_loads(): void
    {
        $this->get('/')->assertOk();
    }
}