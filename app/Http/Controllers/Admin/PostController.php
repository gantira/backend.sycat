<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Posts/Index', [
            'posts' => Post::with('user')
                ->when(request('query'), function ($query) {
                    $query->where('title', 'like', '%' . request('query') . '%');
                })
                ->latest()
                ->paginate(7),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Posts/Create', [
            'categories' => Category::pluck('name', 'id'),
            'tags' => Tag::pluck('name', 'id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'category' => 'nullable',
            'body' => 'required|min:3',
            'thumbnail' => 'nullable|mimes:jpg,png,jpeg|max:2048',
            'status' => 'required|in:published,draft',
        ]);

        if ($request->file('thumbnail')) {
            $thumbnail = Storage::disk('public')->put('images', $request->file('thumbnail'));
        }


        $post = Auth::user()->posts()->create([
            'title' => $request->title,
            'thumbnail' => $thumbnail ?? null,
            'body' => $request->body,
            'status' => $request->status,
        ]);

        $post->categories()->sync($request->category);
        $post->tags()->sync($request->tag);

        session()->flash('message', 'Post stored.');

        return redirect(route('admin.posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return Inertia::render('Admin/Posts/Show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return Inertia::render('Admin/Posts/Edit', [
            'post' => $post->load('categories', 'tags'),
            'categories' => Category::pluck('name', 'id'),
            'tags' => Tag::pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'title' => 'required|min:3|max:255',
            'body' => 'required|min:3',
            'status' => 'required|in:published,draft',
        ]);

        if ($request->file('thumbnail')) {
            if (Storage::disk('public')->exists($post->thumbnail)) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $thumbnail = Storage::disk('public')->put('images', $request->file('thumbnail'));
        }

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'thumbnail' => $thumbnail ?? $post->thumbnail,
            'status' => $request->status,
        ]);

        $post->categories()->sync($request->category);
        $post->tags()->sync($request->tag);

        session()->flash('message', 'Post updated.');

        return redirect(route('admin.posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if (Storage::disk('public')->exists($post->thumbnail)) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->delete();

        session()->flash('message', 'Post deleted.');

        return redirect(route('admin.posts.index'));
    }
}
