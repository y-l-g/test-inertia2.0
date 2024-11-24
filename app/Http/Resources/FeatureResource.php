<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Upvote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class FeatureResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'name' => $this->name,
            'description' => $this->description,
            'user' => new UserResource($this->user),
            'upvote_count' => $this->upvote_count ?? 0,
            'user_vote' => $this->user_vote,
            'comments_count' => $this->comments_count,
        ];
    }
}
