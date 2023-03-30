<?php 

namespace App\ModelFilters;

use App\Models\Category;
use EloquentFilter\ModelFilter;

class PostFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function search($value)
    {
        $this->where('title', 'like', '%'. $value .'%');
    }

    public function categorySelect($value)
    {
        $categoryIds = Category::whereIn('slug', $value)->select('id')->get();
        $this->whereIn('category_id', $categoryIds);
    }
}
