<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'post_id',
        'status',
        'creator_id',
        'updater_id'
    ];

    public function noticeAccount()
    {
        return $this->belongsToMany(Account::class, 'account_notice', 'notice_id', 'account_id')
            ->withPivot('read_at');
    }
}
