<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPendingStudent extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'pending_student_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
    
    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
    }

    public function pendingStudent()
    {
        return $this->belongsTo(PendingStudent::class); 
    }

    public function academicPath()
    {
        return $this->hasMany(AcademicPath::class, 'student_pending_student_id');
    }
}
