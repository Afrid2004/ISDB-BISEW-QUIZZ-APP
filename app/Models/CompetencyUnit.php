<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompetencyUnit extends Model
{
    /** @use HasFactory<\Database\Factories\CompetencyUnitFactory> */
    use HasFactory, SoftDeletes;

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function elements()
    {
        return $this->hasMany(Element::class);
    }
    public function examSets()
    {
        return $this->belongsToMany(ExamSet::class, 'exam_set_competency_units')
            ->withPivot('question_count')
            ->withTimestamps();
    }
}
