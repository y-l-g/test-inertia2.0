<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Feature;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Feature $feature)
    {
        $validated = $request->validate([
            'comment' => ['string', 'required'],
        ]);
        Comment::create(
            [
                'comment' => $validated['comment'],
                'user_id' => auth()->id(),
                'feature_id' => $feature->id
            ]
        );
        return back();
    }

    public function update(Request $request, Comment $comment, Feature $feature)
    {
        $validated = $request->validate([
            'comment' => ['string', 'required'],
        ]);
        $feature->update($validated);
        return back();
    }
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }
        $comment->delete();
        return back();
    }
}
