<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(Post::latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        $post = Post::create(array_merge($validated, [
            'user_id' => $request->user()->id, // authenticated user
            'is_published' => true,
        ]));

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        // Only allow the owner to update
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required',
            'category' => 'nullable|string',
            'image' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $post->update($validated);
        return response()->json($post);
    }

    public function destroy(Request $request, Post $post)
    {
        // Only allow the owner to delete
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();
        return response()->json(['message' => 'Post deleted']);
    }
}
