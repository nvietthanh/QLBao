<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertist extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'name',
        'image',
        'status',
        'created_at',
        'updated_at'
    ];
}
