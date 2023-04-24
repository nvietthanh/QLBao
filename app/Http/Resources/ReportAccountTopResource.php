<?php

namespace App\Http\Resources;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportAccountTopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $account = Account::find($this->account_id);

        return [
            'account_id' => $account->id,
            'account_email' => $account->email,
            'account_status' => $account->status ? true : false,
            'account_name' => $account->accountProfile->getFullName(),
            'count_report' => $this->count_report
        ];
    }
}
