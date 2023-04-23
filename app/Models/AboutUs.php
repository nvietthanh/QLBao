<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'about_us';

    protected $fillable = [
        'name',
        'email',
        'title',
        'images',
        'content',
        'is_reply',
        'created_at',
        'updated_at'
    ];
    
    public function getImagesAttribute($value) {
        if($value) {
            return json_decode($value);
        }
        return [];
    }
}
