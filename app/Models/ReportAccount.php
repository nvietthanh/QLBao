<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAccount extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'content',
        'image',
        'account_report_id',
        'account_id'
    ];

    public function getImageAttribute($value) {
        if($value) {
            return json_decode($value);
        }
        return [];
    }

    public function accountReport()
    {
        return $this->belongsTo(Account::class, 'account_report_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
