<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HagTag extends Model
{
    use HasFactory;

    protected $table = 'hagtags';

    protected $fillable = [
        'name',
        'slug',
        'created_at',
        'updated_at'
    ];

    public function creator()
    {
        return $this->belongsTo(Account::class, 'creator_id', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(Account::class, 'updater_id', 'id');
    }

    public function hastagHasPost()
    {
        return $this->belongsToMany(Post::class, 'post_has_hagtag', 'hagtag_id', 'post_id')
            ->withPivot('created_at');
    }
}
