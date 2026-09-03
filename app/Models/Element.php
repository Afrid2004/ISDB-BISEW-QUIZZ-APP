<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Element extends Model
{
    /** @use HasFactory<\Database\Factories\ElementsFactory> */
    use HasFactory, SoftDeletes;

    public function competencyUnit()
    {
        return $this->belongsTo(CompetencyUnit::class);
    }
    protected $guarded = [];
}
