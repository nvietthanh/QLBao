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
        'is_notice',
        'is_approved',
        'category_id',
        'creator_id',
        'updater_id',
        'updaterable',
        'is_popular',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(Account::class, 'creator_id', 'id');
    }

    public function updaterable()
    {
        return $this->morphTo();
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

    
    public static function getPostByChart($period, $items, $fieldTime)
    {
        $dataPeriod = [];
        $titleBottomChart = [];

        foreach ($period as $key => $date) {
            $totalField = $items
                ->where($fieldTime, '>=', $date->startOfDay())
                ->where($fieldTime, '<=', $date->endOfDay());
            if ($totalField->count() != 0) {
                $dataPeriod[$key] = $totalField->count();
            } else {
                $dataPeriod[$key] = 0;
            }
        }
        foreach ($period as $date) {
            $titleBottomChart[] = $date->format('d') . '/' . $date->format('m') . '/' . $date->format('Y');
        }
        return [
            'dataPeriod' => $dataPeriod,
            'titleBottomChart' => $titleBottomChart,
        ];
    }

    
    public static function getCategoryByChart($categories, $date, $fieldTime)
    {
        $dataPeriod = [];
        $titleBottomChart = [];
        $sum = 0;

        foreach ($categories as $key => $category) {
            $sum += Post::where('category_id', $category->id)->count();
            $totalField = Post::where('category_id', $category->id)
                ->where($fieldTime, '>=', $date[0])
                ->where($fieldTime, '<=', $date[1]);

            if ($totalField->count() != 0) {
                $dataPeriod[$key] = $totalField->count();
            } else {
                $dataPeriod[$key] = 0;
            }

            $titleBottomChart[] = $category->name;
        }
        
        return [
            'dataPeriod' => $dataPeriod,
            'titleBottomChart' => $titleBottomChart,
            'sum' => $sum
        ];
    }
}
