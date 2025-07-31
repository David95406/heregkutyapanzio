<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        $posts = Post::all();
        $posts->transform(function ($post) {
            $post->date = $post->created_at->toDateString();
            return $post;
        });

        return inertia("Index/Index", [
            "posts" => $posts
        ]);
    }
}
