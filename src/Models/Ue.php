<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Ue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'credits',
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

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Calcule la somme des crédits des matières associées.
     */
    public function getTotalCoursesCreditsAttribute()
    {
        return $this->courses->sum('credits');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Valide que la somme des crédits des matières correspond aux crédits de l'UE.
     */
    public function validateCredits()
    {
        if ($this->courses->isEmpty()) {
            return;
        }
        
        $totalCoursesCredits = $this->getTotalCoursesCreditsAttribute();

        if ($totalCoursesCredits > $this->credits) {
            throw ValidationException::withMessages([
                'credits' => "La somme des crédits des matières ({$totalCoursesCredits}) ne peut pas être supérieure aux crédits de l'UE ({$this->credits}).",
            ]);
        }
    }

    /**
     * Événement de sauvegarde pour valider les crédits.
     */
    protected static function booted()
    {
        static::saving(function ($ue) {
            $ue->validateCredits();
        });
    }
}