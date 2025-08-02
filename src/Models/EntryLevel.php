<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryLevel extends Model
{
    use HasFactory;

    protected $fillable = ['entry_diploma_id', 'level', 'academic_year_id', 'department_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
    
    public function entryDiploma()
    {
        return $this->belongsTo(EntryDiploma::class, 'entry_diploma_id');
    }
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
