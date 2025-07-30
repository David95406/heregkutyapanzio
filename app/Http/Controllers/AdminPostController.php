<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function index(Request $request) {
        $posts = Post::all();
        $posts->transform(function ($post) {
            $post->date = $post->created_at->toDateString();
            return $post;
        });

        return inertia("Admin/Posts/Index", [
            "posts" => $posts
        ]);
    }

    public function store(Request $request) {
        return;
    }

    public function update(Request $request) {
        return;
    }

    public function destroy(Request $request) {
        return;
    }
}
