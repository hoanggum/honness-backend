<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class LikeController extends Controller
{
    //
    public function likePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $post = Post::findOrFail($request->input('post_id'));

        $like = Like::firstOrCreate([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        return response()->json([
            'message' => 'Like added successfully',
            'like' => $like,
        ], 201);
    }

    public function unlike($id)
    {
        $user = Auth::user();
        $like = Like::where('user_id', $user->id)
                    ->where('post_id', $id)
                    ->firstOrFail();
        $like->delete();


        return response()->json(['message' => 'Like removed']);
    }
}
