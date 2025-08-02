<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DefenseJuryMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'defense_submission_id',
        'professor_id',
        'grade_id',
        'name',
        'role',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
    
    public function defenseSubmission()
    {
        return $this->belongsTo(DefenseSubmission::class);
    }

    public function professor()
    {
        return $this->belongsTo(\App\Models\Professor::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

}
