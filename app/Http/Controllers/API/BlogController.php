<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StoreBlogRequest;
use App\Http\Requests\Blog\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $blogs = Blog::all();
        return response([ 'blog' => BlogResource::collection($blogs), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBlogRequest $request)
    {
        //
        $data =  $request->validated();

        $data['user_id'] = auth()->user()->id;
        //dd($data);

        $blog = Blog::create($data);

        return response(['blog' => new BlogResource($blog), 'message' => 'Created successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
        return response(['blog' => new BlogResource($blog), 'message' => 'Retrieved successfully'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        //
        if ($blog->user_id == auth()->user()->id) {
            if ($blog->update($request->validated())){
                return response(['blog' => new BlogResource($blog), 'message' => 'Update successfully'], 200);
            }else{
                return response(['message' => 'Server Error'], 500);
            }
        }else{
            return response(['message' => 'Can\' Update This Blog'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
        $blog->delete();

        return response(['message' => 'Deleted']);
    }

    public function my_blogs()
    {
        //
        $blogs = auth()->user()->blogs;
        return response([ 'blogs' => BlogResource::collection($blogs), 'message' => 'Retrieved successfully'], 200);
    }

    public function user_blogs($user_id)
    {
        //
        $user = User::find($user_id);
        $blogs = $user->blogs;
        return response([ 'blogs' => BlogResource::collection($blogs), 'message' => 'Retrieved successfully'], 200);
    }
}
