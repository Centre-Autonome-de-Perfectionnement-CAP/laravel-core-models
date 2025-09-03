<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmdSystemNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_pending_student_id',
        'program_id',
        'notes',
        'moyenne',
        'notes_rattrapage',
        'moyenne_rattrapage',
        'valide',
        'rattrape',
        'reprends',
    ];

    protected $casts = [
        'notes' => 'array',
        'notes_rattrapage' => 'array',
        'moyenne' => 'float',
        'moyenne_rattrapage' => 'float',
        'valide' => 'boolean',
        'rattrape' => 'boolean',
        'reprends' => 'boolean',
    ];

    public function studentPendingStudent()
    {
        return $this->belongsTo(StudentPendingStudent::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
