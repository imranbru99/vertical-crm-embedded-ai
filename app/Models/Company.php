<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name', 'slug', 'industry', 'website', 'phone', 'city', 'country',
        'status', 'annual_revenue', 'meta',
    ];

    protected function casts(): array
    {
        return [
            'annual_revenue' => 'decimal:2',
            'meta' => 'array',
        ];
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }
}