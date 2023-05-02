<?php

namespace App\Models;

use App\Http\Resources\AccountResource;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;

class Account extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    use Filterable;

    protected $fillable = [
        'code',
        'email',
        'password',
        'creator_id',
        'updater_id',
        'userable_type',
        'status',
        'status_expires_at',
        'type_signup'
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

    public function accountHasReadPosts()
    {
        return $this->belongsToMany(Post::class, 'account_read_post', 'account_id', 'post_id')->withPivot('read_at')
            ->orderByPivot('read_at', 'desc');
    }
    
    public function accountHasSavePosts()
    {
        return $this->hasMany(AccountSavePost::class, 'account_id', 'id');
    }

    public function follows()
    {
        return $this->belongsToMany(Account::class, 'follows', 'account_id', 'follower_id')->withPivot('follow_at')
            ->orderByPivot('follow_at', 'desc');
    }

    public function hasFollows()
    {
        return $this->belongsToMany(Account::class, 'follows', 'follower_id', 'account_id');
    }

    public function notices()
    {
        return $this->belongsToMany(Notice::class, 'account_notice', 'account_id', 'notice_id')
            ->withPivot('read_at'); 
    }

    public static function getAccountByChart($period, $items, $fieldTime)
    {
        $dataPeriod = [];
        $titleBottomChart = [];
        $formData = [];
        foreach ($period as $key => $date) {
            $totalField = $items
                ->where($fieldTime, '>=', $date->startOfDay())
                ->where($fieldTime, '<=', $date->endOfDay());
            if ($totalField->count() != 0) {
                $dataPeriod[$key] = $totalField->count();
            } else {
                $dataPeriod[$key] = 0;
            }
            $formData[] = $totalField;
        }
        foreach ($period as $date) {
            $titleBottomChart[] = $date->format('d') . '/' . $date->format('m') . '/' . $date->format('Y');
        }
        return [
            'dataPeriod' => $dataPeriod,
            'titleBottomChart' => $titleBottomChart,
            'formData' => $formData
        ];
    }
}
