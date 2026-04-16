<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

use function Symfony\Component\String\b;

class CommentController extends Controller
{
    public function store(Request $request, $postId)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $postId,
            'content' => $request->content
        ]);


        return back();}

    public function edit($id)
    {
        $comment = Comment::findOrFail($id);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('posts.index');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back();
    }


}
