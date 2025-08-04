<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'classe_id',
        'course_professor_id',
        'semester',
        'pond_session_normale',
        'pond_session_rattrapage',
        'code',
        'hourly_mass',
        'ue_id'
    ];

    protected $casts = [
        'credit' => 'integer',
        'pond_session_normale' => 'array',
        'pond_session_rattrapage' => 'array',
    ];

    public function getPondSessionNormaleAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function getPondSessionRattrapageAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function courseProfessor()
    {
        return $this->belongsTo(CourseProfessor::class, 'course_professor_id');
    }

    public function ue()
    {
        return $this->belongsTo(Ue::class);
    }
}
