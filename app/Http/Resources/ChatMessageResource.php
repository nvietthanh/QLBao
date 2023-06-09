<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'account_send_id' => $this->account_send_id,
            'account_send_name' => $this->accountSend->accountProfile->first_name . ' ' . $this->accountSend->accountProfile->last_name,
            'account_send_image' => $this->accountSend->accountProfile->image,
            'account_receive_id' => $this->account_receive_id,
            'account_receive_name' => $this->accountReceive->accountProfile->first_name . ' ' . $this->accountReceive->accountProfile->last_name,
            'account_receive_image' => $this->accountReceive->accountProfile->image,
            'type' => $this->type,
            'file' => $this->file,
            'content' => $this->content,
            'status' => $this->status ? true : false,
            'created_at' => Carbon::parse($this->created_at)->format('Y/m/d H:i:s'),
        ];
    }
}
