<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingStudent extends Model
{
    use HasFactory;

    protected $fillable = ['personal_information_id', 'tracking_code', 'cuca_opinion', 'cuca_comment', 'cuo_opinion', 'rejection_reason', 'sent_mail_cuca', 'documents', 'level', 'entry_diploma_id', 'photo', 'academic_year_id', 'department_id'];

    public function personalInformation()
    {
        return $this->belongsTo(PersonalInformation::class, 'personal_information_id');
    }

    protected $casts = [
        'pieces' => 'array', 
        'sent_mail_cuca' => 'boolean',
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
    

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function entryDiploma()
    {
        return $this->belongsTo(EntryDiploma::class, 'entry_diploma_id');
    }

    public function getStatusAttribute()
    {
        if ($this->cuo_opinion === 'accepté') {
            return 'Accepté';
        } elseif ($this->cuo_opinion === 'rejeté') {
            return 'Rejeté';
        } elseif ($this->cuca_opinion === 'en attente' || is_null($this->cuo_opinion)) {
            return 'En attente';
        }
        return 'Inconnu';
    }

}
