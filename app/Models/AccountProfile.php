<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'male',
        'date_of_birth',
        'phone',
        'image',
        'description',
        'remark',
        'account_id'
    ];

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
}
