<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_send_id',
        'account_receive_id',
        'last_message',
        'last_account_id',
        'last_message_time',
        'created_at',
        'updated_at'
    ];

    public function accountSend()
    {
        return $this->hasOne(Account::class, 'id', 'account_send_id');
    }

    public function accountReceive()
    {
        return $this->hasOne(Account::class, 'id', 'account_receive_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id', 'id');
    }
}
