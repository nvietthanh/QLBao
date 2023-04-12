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
        'is_approved',
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

    public function postHasAccountReads()
    {
        return $this->belongsToMany(Account::class, 'account_read_post', 'post_id', 'account_id')
            ->withPivot('read_at');
    }

    public function postHasHagtag()
    {
        return $this->belongsToMany(HagTag::class, 'post_has_hagtag', 'post_id', 'hagtag_id')
            ->withPivot('created_at');
    }

    public function postHasAccountSave()
    {
        return $this->hasMany(AccountSavePost::class, 'post_id', 'id');
    }
}
