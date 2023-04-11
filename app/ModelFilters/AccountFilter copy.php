<?php 

namespace App\ModelFilters;

use App\Models\Account;
use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\DB;

class AccountFilter extends ModelFilter
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
        $this->whereHas('accountProfile', function ($q) use ($value) {
                $q->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', '%' . $value . '%');
            })
            ->orwhere('code', 'like', '%' . $value . '%')
            ->orwhere('email', 'like', '%' . $value . '%');
    }

    public function isApproved($value)
    {
        if($value != 2){
            $this->where('status', $value);
        }
    }
}
