<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view("admin.posts.index", compact("posts"));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view("admin.posts.show", compact("post"));
    }

    public function create()
    {
        return view("admin.posts.create");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "title" => "required|max:255",
            "body" => "required",
            "image" => "required|max:255",
        ]);

        $post = Post::create($data);

        return redirect()->route("admin.profile.show")->with("success", "Post created succesfully.");
    }
}
