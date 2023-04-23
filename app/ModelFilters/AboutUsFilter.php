<?php 

namespace App\ModelFilters;

use App\Models\AboutUs;
use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\DB;

class AboutUsFilter extends ModelFilter
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
        $this->orWhere('name', 'like', '%' . $value . '%')
            ->orWhere('email', 'like', '%' . $value . '%');
    }

    public function dateRange($value)
    {
        $this->whereBetween(DB::raw('DATE(created_at)'), [$value[0], $value[1]]);
    }
}
