<?php 

namespace App\ModelFilters;

use App\Models\Account;
use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\DB;

class ReportPostFilter extends ModelFilter
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
        $this->whereHas('post', function ($q) use ($value) {
            $q->where('title',  'like', '%' . $value . '%');
        })
        ->orWhere('content', 'like', '%' . $value . '%');
    }
}
