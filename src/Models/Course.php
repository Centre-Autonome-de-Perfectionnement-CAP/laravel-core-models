<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'hourly_mass' => 'integer',
        'credits' => 'integer',
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

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function professors()
    {
        return $this->belongsToMany(App\Models\Professor::class, 'matiere_professeur')
                    ->withPivot('principal')
                    ->withTimestamps();
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    /**
     * Valide que la somme des crédits des matières correspond aux crédits de l'UE.
     */
    // public function validateUeCredits()
    // {
    //     if ($this->ue_id) {
    //         $ue = $this->ue;
    //         $totalCredits = $ue->courses()->where('id', '!=', $this->id)->sum('credits') + $this->credits;

    //         if ($totalCredits > $ue->credits) {
    //             throw ValidationException::withMessages([
    //                 'credits' => "La somme des crédits des matières ({$totalCredits}) ne doit pas etre supérieure aux crédits de l'UE ({$ue->credits}).",
    //             ]);
    //         }
    //     }
    // }

    /**
     * Événement de sauvegarde pour valider les crédits.
     */
    // protected static function booted()
    // {
    //     static::saving(function ($course) {
    //         $course->validateUeCredits();
    //     });
    // }
}

