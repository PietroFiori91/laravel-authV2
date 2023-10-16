<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostUpsertRequest;
use App\Models\Post;
use Illuminate\Http\Request;
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

    public function store(PostUpsertRequest $request)
    {
        $data = $request->validated();

        $data["slug"] = $this->generateSlug($data["title"]);

        $post = Post::create($data);

        return redirect()->route("admin.posts.show", $post->slug)->with("success", "Post created succesfully.");
    }
    public function edit($slug)
    {
        $post = Post::where("slug", $slug)->firstOrFail();

        return view("admin.posts.edit", compact("post"));
    }

    public function update(PostUpsertRequest $request, $slug)
    {
        $data = $request->validated();
        $post = Post::where("slug", $slug)->firstOrFail();

        if ($data["title"] !== $post->title) {
            $data["slug"] = $this->generateSlug($data["title"]);
        }

        $data["is_published"] = boolval($data["is_published"]);

        // dd($data);

        if ($data["is_published"]) {
            $post->is_published = true;
            $post->published_at = now();
        } else {
            $post->is_published = false;
            $post->published_at = null;
        }

        $post->update($data);

        return redirect()->route("admin.posts.show", $post->slug);
    }

    protected function generateSlug($title)
    {
        //COUNTER PER EVITARE POST CON NOME UGUALE

        $counter = 0;

        do {

            $slug = Str::slug($title) . ($counter > 0 ? "-" . $counter : "");

            $alreadyExists = Post::where("slug", $slug)->first();

            $counter++;
        } while (!$alreadyExists);

        return $slug;
    }
}
