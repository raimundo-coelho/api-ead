<?php

namespace IDEALE\Http\Controllers\Api;


use IDEALE\Http\Requests\ThreadsRequest;
use IDEALE\Http\Resources\threads\ThreadsCollection;
use IDEALE\Http\Resources\threads\ThreadsResource;
use IDEALE\Models\Thread;
use IDEALE\Http\Controllers\Controller;

class ThreadsController extends Controller
{

    public function index()
    {
        $threads =  Thread::all();
        return new ThreadsCollection($threads);
    }


    public function store(ThreadsRequest $request)
    {
        $thread = Thread::create($request->all());
        return new ThreadsResource($thread);
    }


    public function show(Thread $thread)
    {
        return new ThreadsResource($thread);
    }


    public function update(ThreadsRequest $request, Thread $thread)
    {
        $thread->fill($request->all());
        $thread->save();
        return new ThreadsResource($thread);
    }

    public function destroy(Thread $thread)
    {
        $thread->delete();
        return response()->json([], 204);
    }
}
