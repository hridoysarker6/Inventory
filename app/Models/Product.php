<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'price',
        'quantity',
        'unit',
        'description',
        'status',
        'image',
    ];

    public function scopeMatchCode(Builder $builder, $code)
    {
        return $builder->where('code', $code);
    }

    public function scopeIsActive(Builder $builder)
    {
        return $builder->where('status', 1);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Storage::url($value) : null,
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? 'Active' : 'InActive',
        );
    }
}
