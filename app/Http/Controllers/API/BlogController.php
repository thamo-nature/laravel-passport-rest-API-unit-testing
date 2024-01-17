<?php

namespace App\Http\Controllers\API;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::all();
        return response(['blogs' => BlogResource::collection($blogs)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] =  Auth::user()->id;
        $validator = Validator::make($data, [
            'blog_title' => 'required',
            'blog_content' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $blog = Blog::create($data);

        return response(['blog' => new BlogResource($blog), 'message' => 'Blog created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return response(['blog' => new BlogResource($blog)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $data = $request->all();
        $user_id = Auth::user()->id;
        $data['user_id'] =  Auth::user()->id;
        $validator = Validator::make($data, [
            
            'blog_title' => 'required',
            'blog_content' => 'required',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $blog->update($data);

        return response(['blog' => new BlogResource($blog), 'message' => 'Blog updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return response(['message' => 'Blog deleted successfully']);
    }
}
