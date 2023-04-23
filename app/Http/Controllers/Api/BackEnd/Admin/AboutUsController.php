<?php

namespace App\Http\Controllers\Api\BackEnd\Admin;

use App\Exceptions\FailException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AboutUsRequest;
use App\Http\Requests\ReplyContactRequest;
use App\Http\Requests\SendContactRequest;
use App\Http\Resources\AboutUsResource;
use App\Jobs\ReplyContactEmail;
use App\Models\AboutUs;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = Page::select(['title', 'content'])->where('type', 'about-us')->first();

        return response()->json($aboutUs);
    }

    public function update(AboutUsRequest $request)
    {
        $request->validated();

        DB::beginTransaction();
        try {
            
            $aboutUs = Page::where('type', 'about-us')->first();

            if($aboutUs) {
                $aboutUs->update([
                    'title' => $request->title,
                    'content' => $request->content
                ]);
            }
            else {
                Page::create([
                    'type' => 'about-us',
                    'title' => $request->title,
                    'content' => $request->content
                ]);
            }

            DB::commit();

            return response()->json(200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function getList(Request $request)
    {
        $aboutUs = AboutUs::filter($request->all())
            ->orderBy('created_at')->paginate($request->limit ?? 6);

        return AboutUsResource::collection($aboutUs);
    }

    public function send(SendContactRequest $request)
    {
        $request->validated();

        $paths = [];

        if($request->file('images')) {
            foreach($request->file('images') as $image) {
                $path = Storage::putFile('public/contacts', $image);
                array_push($paths, Storage::url($path));
            }
        }

        AboutUs::create(array_merge(
            $request->only(['name', 'email', 'title', 'content']),
            [
                'images' => $paths ? json_encode($paths) : '',
                ]
        ));

        return response()->json(true);
    }

    public function deleteContact($id)
    {
        $aboutUs = AboutUs::find($id);

        if(!$aboutUs) {
            throw new FailException('Xóa liên hệ không thành công');
        }

        $aboutUs->delete();

        return response()->json(true);
    }

    public function deleteContacts(Request $request)
    {
        $contactIds = $request->contactIds;

        foreach($contactIds as $contact) {
            $aboutUs = AboutUs::find($contact['id']);

            if($aboutUs) {
                $aboutUs->delete();
            }
        }

        return response()->json(true);
    }

    public function getContact($id)
    {
        $aboutUs = AboutUs::find($id);

        if (!$aboutUs) {
            throw new FailException('Không tìm thấy liên hệ');
        }

        return AboutUsResource::make($aboutUs);
    }

    public function sendEmailContact($id, ReplyContactRequest $request)
    {
        $request->validated();

        $content = $request->content;
        $aboutUs = AboutUs::find($id);

        if(!$aboutUs) {
            throw new FailException('Gửi email không thành công');   
        }

        ReplyContactEmail::dispatch($aboutUs->email, $content, $aboutUs->name);

        $aboutUs->update([
            'is_reply' => 1
        ]);

        return response()->json(true);
    }
}
