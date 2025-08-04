<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseResource extends Model
{
    use HasFactory;

    protected $table = 'course_resources';

    protected $fillable = [
        'course_id',
        'file_name',
        'file_path',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}