<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostStoreRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{
    public function index()
    {
        $books = Post::active()
            ->with('website:id,name,url')
            ->paginate();

        return PostResource::collection($books);
    }

    public function store(PostStoreRequest $request)
    {
        $validatedData = $request->validated();

        $post = Post::query()->create($validatedData);

        PostResource::withoutWrapping();

        return (new PostResource($post))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     *
     */
    public function show(Request $request, $id)
    {
        try {
            $post = Post::query()->findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'type'  => 'error',
                'title' => __('Could not find '),
                'message' => __('Model not found!'),
                'data' =>  $th->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }

        $post->load('author');

        PostResource::withoutWrapping();
        return new PostResource($post);
    }


    public function update(PostStoreRequest $request, $id)
    {
        try {
            $post = Post::query()->findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'title' => __('Error'),
                'message' => __('Model not found!'),
                'data' =>  $th->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validated();
        $post->update($validatedData);

        PostResource::withoutWrapping();
        return (new PostResource($post))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        try {
            $post = Post::query()->findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'title' => __('Error'),
                'message' => __('Model not found!'),
                'data' =>  $th->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        }

        if(!$post->delete()){
            throw new \Exception('Could Not delete Post');
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
