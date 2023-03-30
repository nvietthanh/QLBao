<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;

class Account extends Authenticatable
{
    use HasFactory;
    use HasRoles;

    protected $fillable = [
        'code',
        'email',
        'password',
        'creator_id',
        'updater_id',
        'userable_type'
    ];

    public function accountProfile()
    {
        return $this->hasOne(AccountProfile::class, 'account_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'creator_id', 'id');
    }

    public function accountComments()
    {
        return $this->belongsToMany(Comment::class, 'like_comment_post', 'account_id', 'comment_id');
    }
}
