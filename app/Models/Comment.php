<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'account_id',
        'post_id',
        'is_change',
        'parent_id',
        'created_at',
        'updated_at'
    ];
    
    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function commentsHasLikeAccounts()
    {
        return $this->belongsToMany(Account::class, 'like_comment_post', 'comment_id', 'account_id');
    }
}