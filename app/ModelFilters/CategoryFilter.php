<?php 

namespace App\ModelFilters;

use App\Models\Category;
use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\DB;

class CategoryFilter extends ModelFilter
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
        $this->orwhere('name', 'like', '%' . $value . '%');
    }

    public function isApproved($value)
    {
        if($value != 2){
            $this->where('status', $value);
        }
    }
}
