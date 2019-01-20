<?php

namespace IDEALE\Http\Controllers\Api;

use IDEALE\Http\Requests\ReplyRequest;
use IDEALE\Http\Resources\replies\RepliesResource;
use IDEALE\Http\Resources\reply\ReplyCollection;
use IDEALE\Models\Reply;
use IDEALE\Http\Controllers\Controller;

class ReplyController extends Controller
{
    public function index()
    {
        $replys =  Reply::all();
        return new ReplyCollection($replys);
    }


    public function store(ReplyRequest $request)
    {
        $reply = Reply::create($request->all());
        return new RepliesResource($reply);
    }


    public function show(Reply $reply)
    {
        return new RepliesResource($reply);
    }


    public function update(ReplyRequest $request, Reply $reply)
    {
        $reply->fill($request->all());
        $reply->save();
        return new RepliesResource($reply);
    }

    public function destroy(Reply $reply)
    {
        $reply->delete();
        return response()->json([], 204);
    }
}
