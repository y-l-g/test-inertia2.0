<?php

namespace App\Http\Controllers;

use App\Http\Resources\FeatureResource;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->user()->id;
        return Inertia::render('Feature/Index', [
            'features' => FeatureResource::collection(
                Feature::latest()
                    ->withCount([
                        'upvotes as upvote_count' => function ($query) {
                            $query->select(DB::raw("SUM(CASE WHEN upvote = 1 THEN 1 WHEN upvote = 0 THEN -1 ELSE 0 END)"));
                        }
                    ])
                    ->withExists([
                        'upvotes as user_has_upvoted' => function ($query) use ($userId) {
                            $query->where('user_id', $userId)->where('upvote', 1);
                        },
                        'upvotes as user_has_downvoted' => function ($query) use ($userId) {
                            $query->where('user_id', $userId)->where('upvote', 0);
                        }
                    ])
                    ->paginate()
            )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Feature/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['string', 'required'],
            'description' => ['string', 'nullable']
        ]);
        $data['user_id'] = auth()->id();
        Feature::create($data);
        return to_route('features.index')->with('success', 'Feature created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Feature $feature)
    {
        $userId = auth()->user()->id;
        return Inertia::render('Feature/Show', [
            'feature' => new FeatureResource(
                Feature::where('id', $feature->id)
                    ->withCount([
                        'upvotes as upvote_count' => function ($query) {
                            $query->select(DB::raw("SUM(CASE WHEN upvote = 1 THEN 1 WHEN upvote = 0 THEN -1 ELSE 0 END)"));
                        }
                    ])
                    ->withExists([
                        'upvotes as user_has_upvoted' => function ($query) use ($userId) {
                            $query->where('user_id', $userId)->where('upvote', 1);
                        },
                        'upvotes as user_has_downvoted' => function ($query) use ($userId) {
                            $query->where('user_id', $userId)->where('upvote', 0);
                        }
                    ])->first()
            )
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feature $feature)
    {
        return Inertia::render('Feature/Edit', [
            'feature' => new FeatureResource($feature)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feature $feature)
    {
        $data = $request->validate([
            'name' => ['string', 'required'],
            'description' => ['string', 'nullable']
        ]);
        $feature->update($data);
        return to_route('features.index')->with('success', 'Feature updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();
        return to_route('features.index')->with('success', 'Feature has been deleted succesfully');

    }
}
