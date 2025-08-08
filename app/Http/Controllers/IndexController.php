<?php

namespace App\Http\Controllers;

use App\Models\Post;

class IndexController extends Controller
{
    public function index() {
        $posts = Post::latest()->take(9)->get();
        $posts->transform(function ($post) {
            $post->date = $post->created_at->toDateString();
            return $post;
        });

        return inertia("Index/Index", [
            "posts" => $posts
        ]);
    }
}
