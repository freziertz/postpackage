<?php

namespace Freziertz\PostPackage\Http\Controllers;


use Freziertz\PostPackage\Models\Post;
use Freziertz\PostPackage\Publishing\Enums\PostStatus;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Freziertz\PostPackage\Events\PostWasCreated;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return view('postpackage::posts.index', compact('posts'));
    }

    public function show()
    {
        $post = Post::findOrFail(request('post'));

        return view('postpackage::posts.show', compact('post'));
    }

    public function store()
    {
        // Let's assume we need to be authenticated
        // to create a new post
        if (! auth()->check()) {
            abort (403, 'Only authenticated users can create new posts.');
        }

        request()->validate([
            'title' => 'required',
            'content'  => 'required',
        ]);

        // Assume the authenticated user is the post's author
        $author = auth()->user();

        $title = request('title');

        $status = Arr::random(PostStatus::cases());  

        $post = $author->posts()->create([
            'title'     => request('title'),
            'content'      => request('content'),
            'slug'      => Str::slug($title),
            'status'      => $status->value,
            'published_at' => $status === PostStatus::PUBLISHED ? now() : null,
        ]);


        event(new PostWasCreated($post));

        return redirect(route('posts.show', $post));
    }
}
