<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamSetQuestion extends Model
{
    use HasFactory, SoftDeletes;
    public function examSet()
    {
        return $this->belongsTo(ExamSet::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}