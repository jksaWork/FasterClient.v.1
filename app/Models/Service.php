<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'descr',
        'is_active',

        'photo',
    ];

    public function notes()
    {
        return $this->hasMany(ServiceNote::class);
    }

    protected $casts = [
        'is_active' => 'boolean',
        'is_fill_sender' => 'boolean',
    ];
}
