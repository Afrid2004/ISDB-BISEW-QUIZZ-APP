<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamSet extends Model
{
    /** @use HasFactory<\Database\Factories\ExamSetFactory> */
    use HasFactory, SoftDeletes;

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function competencyUnits()
    {
        return $this->belongsToMany(CompetencyUnit::class, 'exam_set_competency_units')
            ->withPivot('question_count')
            ->withTimestamps();
    }

    public function competencyUnitMappings()
    {
        return $this->hasMany(ExamSetCompetencyUnit::class);
    }
}
