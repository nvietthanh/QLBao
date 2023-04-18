<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'image' => $this->image,
            'account_id' => $this->account->id,
            'account_email' => $this->account->email,
            'account_status' => $this->account->status ? true : false,
            'account_name' => $this->account->accountProfile->getFullName(),
            'account_report_name' => $this->accountReport->accountProfile->getFullName(),
            'account_report_email' => $this->accountReport->email,
            'created_at' => Carbon::create($this->created_at)->format('Y-m-d H:i'),
            'updated_at' => Carbon::create($this->updated_at)->format('Y-m-d H:i'),
        ];
    }
}
