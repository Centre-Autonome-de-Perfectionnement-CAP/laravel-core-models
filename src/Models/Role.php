<?php

namespace Cap\LaravelCoreModels\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'permissions'
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
    public function hasPermission($permission)
    {
        $permissions = json_decode($this->permissions, true);
        return in_array($permission, $permissions);
    }

    public function administration()
    {
        return $this->hasMany(\App\Models\Administration::class);
    }

    public function academicPath()
    {
        return $this->hasMany(AcademicPath::class);
    }
}
