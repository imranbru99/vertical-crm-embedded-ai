<?php

namespace App\Services;

use App\Models\VerticalField;
use Illuminate\Support\Collection;

class VerticalFieldService
{
    public function forVertical(string $vertical, string $entity = 'deal'): Collection
    {
        return VerticalField::query()
            ->where('vertical', $vertical)
            ->where('entity_type', $entity)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }
}