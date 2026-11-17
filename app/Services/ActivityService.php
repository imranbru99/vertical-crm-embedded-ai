<?php

namespace App\Services;

use App\Models\Activity;

class ActivityService
{
    public function log(array $data): Activity
    {
        return Activity::query()->create(array_merge([
            'occurred_at' => now(),
            'type' => 'note',
        ], $data));
    }
}