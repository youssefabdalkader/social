<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle($id)
    {
        $like = Like::where('user_id', auth()->id())
            ->where('post_id', $id)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $id
            ]);
        }

        return back();
    }
}
