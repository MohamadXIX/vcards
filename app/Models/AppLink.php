<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppLink extends Model
{
   protected $fillable = [
        'name',
        'ios_url',
        'android_url',
        'slug',
    ];
}
