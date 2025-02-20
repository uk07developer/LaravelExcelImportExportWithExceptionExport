<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'device_id',
        'template_id', // ✅ Added this line
        'keyword',
        'reply',
        'match_type',
        'reply_type',
        'api_key',
    ];
}
