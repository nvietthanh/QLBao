<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportPost extends Model
{
    use HasFactory;
    use Filterable;

    protected $fillable = [
        'content',
        'image',
        'account_report_id',
        'post_id'
    ];
    
    public function getImageAttribute($value) {
        if($value) {
            return json_decode($value);
        }
        return [];
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function accountReport()
    {
        return $this->belongsTo(Account::class, 'account_report_id', 'id');
    }
}
