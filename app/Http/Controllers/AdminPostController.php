<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function index(Request $request) {
        $posts = Post::all();
        //$posts = Post::latest()->take(8)->get();
        $posts->transform(function ($post) {
            $post->date = $post->created_at->toDateString();
            return $post;
        });

        return inertia("Admin/Posts/Index", [
            "posts" => $posts
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'imageUrl' => 'required|string|max:16383',
            'title' => 'required|string|max:255',
            'text' => 'required|string|max:16383',
        ]);
        
        Post::create($validated);
        
        return redirect()->route('posts.index')
            ->with('message', 'Post created successfully');
    }

    public function update(Request $request, Post $post) {
        $validated = $request->validate([
            'imageUrl' => 'required|string|max:16383', // a 16383 save place
            'title' => 'required|string|max:255',
            'text' => 'required|string|max:16383',
        ]);
        
        $post->update($validated);
        
        return redirect()->route('posts.index')
            ->with('message', 'Post updated successfully');
    }

    public function destroy(Request $request, Post $post) {
        $post->delete();
        
        return redirect()->route('posts.index')
            ->with('message', 'Post deleted successfully');
    }
}
