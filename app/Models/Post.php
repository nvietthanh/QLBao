<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;

class Post extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image',
        'is_confirm',
        'category_id',
        'creator_id',
        'updater_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(Account::class, 'creator_id', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(Account::class, 'updater_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
