<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'content' => 'required|string',
            'image' => 'nullable|image',
        ]);
    }
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return response()->json($posts);
    }
    
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $user = Auth::user();

        $post = new Post();
        $post->user_id = $user->id;
        $post->content = $request->input('content');

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        return response()->json([
            'message' => 'Create Post successful',
            'post' => $post
        ], 201);
    }

    public function show($id)
    {
        $post = Post::with('user', 'comments', 'likes')->findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $post = Post::findOrFail($id);
        $post->content = $request->input('content');

        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts', 'public');
        }

        $post->save();

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }
}
