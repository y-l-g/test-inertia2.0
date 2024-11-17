<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\Upvote;
use Illuminate\Http\Request;

class UpvoteController extends Controller
{
    public function upvote(Request $request, Feature $feature)
    {
        $userId = auth()->id();
        $upvote = Upvote::where('user_id', $userId)
            ->where('feature_id', $feature->id)
            ->first();
        if ($upvote) {
            if (!$upvote->upvote) {
                $upvote->delete();
            }
        } else {
            Upvote::create([
                'user_id' => $userId,
                'feature_id' => $feature->id,
                'upvote' => true,
            ]);
        }
        return back();
    }

    public function downvote(Request $request, Feature $feature)
    {
        $userId = auth()->id();
        $upvote = Upvote::where('user_id', $userId)
            ->where('feature_id', $feature->id)
            ->first();
        if ($upvote) {
            if ($upvote->upvote) {
                $upvote->delete();
            }
        } else {
            Upvote::create([
                'user_id' => $userId,
                'feature_id' => $feature->id,
                'upvote' => false,
            ]);
        }
        return back();
    }
}

