<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinimalAverage extends Model
{
    use HasFactory;

    protected $fillable = [
        'cycle_id',
        'academic_year_id',
        'minimal_average',
    ];

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
