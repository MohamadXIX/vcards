<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contact extends Model
{
     use HasFactory;
   protected $fillable = [
        'uuid',
        'name',
        'phone',
        'email',
        'company',
        'job_title',
        'website',
        'address',
        'notes',
        'is_active',
    ];

    protected static function booted()
    {
        static::creating(function ($contact) {
            if (empty($contact->uuid)) {
                $contact->uuid = Str::uuid()->toString();
            }
        });
    }
}
