<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldSystemNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_pending_student_id',
        'program_id',
        'notes',
        'moyenne',
    ];

    protected $casts = [
        'notes' => 'array',
        'moyenne' => 'float',
    ];

    public function getNotesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function studentPendingStudent()
    {
        return $this->belongsTo(StudentPendingStudent::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}