<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'content',
        'file',
        'status',
        'account_send_id',
        'account_receive_id',
        'conversation_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'file' => 'array',
    ];

    public function accountSend()
    {
        return $this->hasOne(Account::class, 'id', 'account_send_id');
    }

    public function accountReceive()
    {
        return $this->hasOne(Account::class, 'id', 'account_receive_id');
    }
}
