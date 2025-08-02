<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name', 'abbreviation'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
    
    public function juryMembers()
    {
        return $this->hasMany(DefenseJuryMember::class);
    }
}
