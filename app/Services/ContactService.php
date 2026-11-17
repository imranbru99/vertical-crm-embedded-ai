<?php

namespace App\Services;

use App\Models\Contact;

class ContactService
{
    public function upsert(array $data): Contact
    {
        return Contact::query()->updateOrCreate(
            ['email' => $data['email'] ?? null, 'company_id' => $data['company_id'] ?? null],
            $data
        );
    }
}