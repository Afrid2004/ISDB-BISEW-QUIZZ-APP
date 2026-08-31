<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'batches';

    protected $fillable = [
        'round_id',
        'training_center_id',
        'shift_id',
        'batch_number',
        'name',
        'description',
        'max_students',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_students' => 'integer',
    ];

    public function round()
    {
        return $this->belongsTo(Round::class, 'round_id');
    }

    public function trainingCenter()
    {
        return $this->belongsTo(TrainingCenter::class, 'training_center_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }
}
