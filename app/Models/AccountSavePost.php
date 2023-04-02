<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountSavePost extends Model
{
    use HasFactory;

    public $table = 'account_save_post';

    protected $fillable = [
        'account_id',
        'post_id',
        'created_at',
        'updated_at'
    ];
}
