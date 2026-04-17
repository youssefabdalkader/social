<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
     public function index()
    {
        $posts = Post::with(['user','likes','comments.user'])
            ->where('is_published', true)
            ->latest('updated_at')
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

public function store(Request $request)
{
    $path = null;

    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('posts', 'public');
    }

    Post::create([
        'user_id' => auth()->id(),
        'content' => $request->content,
        'image' => $path,
    ]);






    return back();
}
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }
    public function update(Request $request, $id)
{
    $post = Post::findOrFail($id);

    $data = [
        'content' => $request->content,
    ];

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('posts', 'public');
    }

    $post->update($data);

    return redirect()->route('posts.index');
}

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return back();
    }
}
