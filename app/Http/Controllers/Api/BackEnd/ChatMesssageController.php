<?php

namespace App\Http\Controllers\Api\BackEnd;

use App\Events\ChangeStatusMessageEvent;
use App\Events\SendMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\AccountMessageResource;
use App\Http\Resources\ChatMessageResource;
use App\Models\Account;
use App\Models\ChatMessage;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChatMesssageController extends Controller
{
    public function listAccount()
    {
        $currentAccount = auth('accounts')->user();

        $account = Conversation::where('account_send_id', $currentAccount->id)
                ->orWhere('account_receive_id', $currentAccount->id)
                ->orderBy('last_message_time', 'desc')
                ->get();

        return AccountMessageResource::collection($account);
    }

    public function listMessage($id)
    {
        $account =  Account::find($id);

        $currentAccount = auth('accounts')->user();

        $conversation = Conversation::where(function($query) use ($account, $currentAccount) {
                $query->where('account_send_id', $account->id)
                    ->where('account_receive_id', $currentAccount->id);
            })
            ->orWhere(function($query) use ($account, $currentAccount) {
                $query->where('account_send_id', $currentAccount->id)
                    ->where('account_receive_id', $account->id);
            })->first();

        $messsages = ChatMessage::where('conversation_id', $conversation->id)->get();

        return ChatMessageResource::collection($messsages);
    }

    public function sendMessage(Request $request)
    {
        $account =  Account::find($request->id);
        $currentAccount = auth('accounts')->user();

        $conversation = Conversation::where(function($query) use ($account, $currentAccount) {
                $query->where('account_send_id', $account->id)
                    ->where('account_receive_id', $currentAccount->id);
            })
            ->orWhere(function($query) use ($account, $currentAccount) {
                $query->where('account_send_id', $currentAccount->id)
                    ->where('account_receive_id', $account->id);
            })->first();

        if(!$conversation) {
            $conversation = Conversation::create([
                'account_send_id' => $currentAccount->id,
                'account_receive_id' => $account->id,
            ]);
        }

        if($request->message) {
            $type = 0;
        }
        else if(count($request->images) > 0) {
            $type = 1;
            $paths = [];
            foreach($request->images as $image) {
                $path = Storage::putFile('public/messages', $image);
                $paths[] = Storage::url($path);
            }
        }
        else if(count($request->file)) {
            $type = 2;
        }

        $conversation->update([
            'last_message' => $type == 0 ? $request->message : 'Đã gửi ' .count($request->images). ' hình ảnh',
            'last_account_id' => $currentAccount->id,
            'last_message_time' => now()
        ]);

        $message = ChatMessage::create([
            'type' => $type,
            'content' => $type == 0 ? $request->message : '',
            'file' => $type == 1 || $type == 2 ? $paths : '',
            'account_send_id' => $currentAccount->id,
            'account_receive_id' => $account->id,
            'conversation_id' => $conversation->id
        ]);
        
        return event(new SendMessageEvent(ChatMessageResource::make($message), $currentAccount->id, $account->id));
    }

    public function changeStatus($id)
    {
        $account =  Account::find($id);

        $currentAccount = auth('accounts')->user();

        $conversation = Conversation::where(function($query) use ($account, $currentAccount) {
                $query->where('account_send_id', $account->id)
                    ->where('account_receive_id', $currentAccount->id);
            })
            ->orWhere(function($query) use ($account, $currentAccount) {
                $query->where('account_send_id', $currentAccount->id)
                    ->where('account_receive_id', $account->id);
            })->first();

        $messages = ChatMessage::where('conversation_id', $conversation->id)
            ->where('account_send_id', $account->id)
            ->where('status', 0)
            ->get();

        foreach($messages as $message) {
            $message->update([
                'status' => 1
            ]);
        }

        event(new ChangeStatusMessageEvent(1, $currentAccount->id, $account->id));

        return response()->json(true);
    }

    public function searchAccount(Request $request)
    {
        $currentAccount = auth('accounts')->user();

        $accounts = Account::whereHas('accountProfile', function ($query) use ($request) {
                $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', '%'.$request->keyword.'%');
            })
            ->where('id', '<>', $currentAccount->id)
            ->get();
        
        $accountResult = [];

        foreach($accounts as $account) {
            $accountResult[] = [
                'account_id' => $account->id,
                'account_name' => $account->accountProfile->first_name . ' ' .$account->accountProfile->last_name,
                'account_image' => $account->accountProfile->image,
                'is_account_send' => '',
                'status' => '',
                'last_message' => '',
                'last_message_time' => ''
            ];
        }
        
        return $accountResult;
    }
}
