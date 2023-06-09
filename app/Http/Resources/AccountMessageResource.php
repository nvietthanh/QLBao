<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccountMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $currentAccount = auth('accounts')->user();

        if($this->account_send_id == $currentAccount->id) {
            return [
                'account_id' => $this->account_receive_id,
                'account_name' => $this->accountReceive->accountProfile->first_name . ' ' .$this->accountReceive->accountProfile->last_name,
                'account_image' => $this->accountReceive->accountProfile->image,
                'last_account_id' => $this->last_account_id == $currentAccount->id ? false : true,
                'status' => $this->messages->last() ? $this->messages->last()->status : '',
                'last_message' => $this->last_message,
                'last_message_time' => $this->last_message_time ? Carbon::parse($this->last_message_time)->format('Y-m-d H:i:s'): ''
            ];
        }
        else {
            return [
                'account_id' => $this->account_send_id,
                'account_name' => $this->accountSend->accountProfile->first_name . ' ' .$this->accountSend->accountProfile->last_name,
                'account_image' => $this->accountSend->accountProfile->image,
                'last_account_id' => $this->last_account_id == $currentAccount->id ? false : true,
                'status' => $this->messages->last() ? $this->messages->last()->status : '',
                'last_message' => $this->last_message,
                'last_message_time' => $this->last_message_time ? Carbon::parse($this->last_message_time)->format('Y-m-d H:i:s'): ''
            ];
        }

    }
}
