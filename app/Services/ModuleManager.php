<?php

namespace App\Services;

use App\Models\ModuleSetting;
use Illuminate\Support\Facades\Cache;

class ModuleManager
{
    public function all(): array
    {
        $config = config('modules', []);
        $overrides = Cache::remember('module_settings', 60, function () {
            try {
                return ModuleSetting::query()->pluck('enabled', 'key')->all();
            } catch (\Throwable) {
                return [];
            }
        });

        foreach ($config as $key => &$module) {
            if (array_key_exists($key, $overrides)) {
                $module['enabled'] = (bool) $overrides[$key];
            }
        }

        return $config;
    }

    public function enabled(string $key): bool
    {
        return (bool) ($this->all()[$key]['enabled'] ?? false);
    }

    public function toggle(string $key, bool $enabled): void
    {
        ModuleSetting::query()->updateOrCreate(['key' => $key], ['enabled' => $enabled]);
        Cache::forget('module_settings');
    }

    public function syncFromConfig(): void
    {
        foreach (config('modules', []) as $key => $module) {
            ModuleSetting::query()->updateOrCreate(
                ['key' => $key],
                ['enabled' => (bool) ($module['enabled'] ?? true), 'meta' => ['name' => $module['name'] ?? $key]]
            );
        }
        Cache::forget('module_settings');
    }

    public function enabledKeys(): array
    {
        return collect($this->all())->filter(fn (array $m) => $m['enabled'] ?? false)->keys()->all();
    }
}