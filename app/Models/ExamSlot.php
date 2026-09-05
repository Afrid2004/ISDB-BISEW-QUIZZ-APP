<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamSlot extends Model
{
    /** @use HasFactory<\Database\Factories\ExamSlotFactory> */
    use HasFactory, SoftDeletes;

    // Convert date-time fields into  date formatting
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function examSet()
    {
        return $this->belongsTo(ExamSet::class);
    }
}
