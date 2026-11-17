<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerticalField extends Model
{
    protected $fillable = [
        'vertical', 'entity_type', 'field_key', 'label', 'field_type',
        'options', 'is_required', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'options' => 'array',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
        ];
    }
}