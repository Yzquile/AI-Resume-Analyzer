<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'file_path',
        'file_name',
        'candidate_name',
        'skills',
        'years_experience',
        'education',
        'suggested_role',
        'raw_text',
        'ai_response',
    ];

    protected $casts = [
        'skills' => 'array',
        'ai_response' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}