<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view("admin.posts.index", compact("posts"));
    }

    public function show($slug)
    {
        $post = Post::where("slug", $slug)->first();

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

        //COUNTER PER EVITARE POST CON NOME UGUALE

        $counter = 0;

        do {

            $slug = Str::slug($data["title"]) . ($counter > 0 ? "-" . $counter : "");

            $alreadyExists = Post::where("slug", $data["slug"])->first();

            $counter++;
        } while (!$alreadyExists);

        $data["slug"] = $slug;




        $post = Post::create($data);

        return redirect()->route("admin.posts.show", $post->id)->with("success", "Post created succesfully.");
    }
}
