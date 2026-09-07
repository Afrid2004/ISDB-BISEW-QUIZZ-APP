<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
