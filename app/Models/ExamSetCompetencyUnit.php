<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamSetCompetencyUnit extends Model
{
    /** @use HasFactory<\Database\Factories\ExamSetCompetencyUnitFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exam_set_id',
        'competency_unit_id',
        'question_count',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function examSet()
    {
        return $this->belongsTo(ExamSet::class);
    }

    public function competencyUnit()
    {
        return $this->belongsTo(CompetencyUnit::class);
    }
}
