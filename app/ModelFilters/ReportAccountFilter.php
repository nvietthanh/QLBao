<?php 

namespace App\ModelFilters;

use App\Models\ReportAccount;
use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\DB;

class ReportAccountFilter extends ModelFilter
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
        $this->whereHas('account', function ($q) use ($value) {
                $q->where('email',  'like', '%' . $value . '%');
            })
            ->orWhere('content', 'like', '%' . $value . '%');
    }
}
