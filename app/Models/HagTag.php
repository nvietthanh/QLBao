<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HagTag extends Model
{
    use HasFactory;
    use Filterable;

    protected $table = 'hagtags';

    protected $fillable = [
        'name',
        'slug',
        'created_at',
        'updated_at'
    ];

    public function hastagHasPost()
    {
        return $this->belongsToMany(Post::class, 'post_has_hagtag', 'hagtag_id', 'post_id')
            ->withPivot('created_at');
    }
}
