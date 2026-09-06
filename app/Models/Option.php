<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /** @use HasFactory<\Database\Factories\OptionFactory> */
    use HasFactory;

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    protected $fillable = [
        'question_id',
        'option',
        'is_correct'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];
}
