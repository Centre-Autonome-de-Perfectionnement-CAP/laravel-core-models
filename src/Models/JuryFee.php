<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Model;

class JuryFee extends Model
{
    protected $fillable = [
        'degree_type', 
        'role',
        'amount'
    ];
    
    protected $casts = [
        'amount' => 'integer'
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
    
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 0, ',', ' ');
    }
}
