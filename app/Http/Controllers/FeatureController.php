<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\FeatureResource;
use App\Http\Resources\IndexFeatureResource;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->integer('page', 1);

        $paginated = Feature::leftJoin('upvotes', 'features.id', '=', 'upvotes.feature_id')
            ->select(
                'features.id',
                'features.name',
                'features.description',
                'features.created_at',
                DB::raw("SUM(CASE WHEN upvotes.upvote = 1 THEN 1 WHEN upvotes.upvote = 0 THEN -1 ELSE 0 END) as upvote_count"),
                DB::raw("MAX(CASE WHEN upvotes.user_id = " . auth()->id() . " THEN upvotes.upvote END) as user_vote")
            )
            ->groupBy('features.id')
            ->with('user:id')
            ->withCount('comments')
            ->latest('features.created_at')
            ->paginate();
        return Inertia::render('Feature/Index', [
            'features' => Inertia::merge(FeatureResource::collection($paginated->items())->collection),
            'lastPage' => $paginated->lastPage(),
            'page' => $page,
        ]);
    }
    public function create()
    {
        return Inertia::render('Feature/Create');
    }
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

    public function show(Request $request, Feature $feature)
    {
        $page = $request->integer('page', 1);

        $paginated = $feature->comments()
            ->select('id', 'comment', 'user_id', 'feature_id', 'created_at')
            ->with('user:id,name')
            ->latest('created_at')
            ->paginate(10);

        return Inertia::render('Feature/Show', [
            'feature' => fn() =>
                new FeatureResource(Feature::leftJoin('upvotes', 'features.id', '=', 'upvotes.feature_id')
                    ->select(
                        'features.id',
                        'features.name',
                        'features.description',
                        'features.created_at',
                        DB::raw("SUM(CASE WHEN upvotes.upvote = 1 THEN 1 WHEN upvotes.upvote = 0 THEN -1 ELSE 0 END) as upvote_count"),
                        DB::raw("MAX(CASE WHEN upvotes.user_id = " . auth()->id() . " THEN upvotes.upvote ELSE NULL END) as user_vote")
                    )
                    ->where('features.id', $feature->id)
                    ->groupBy('features.id')
                    ->with([
                        'user:id,name',
                    ])
                    ->firstOrFail()),

            'comments' => Inertia::merge(CommentResource::collection($paginated->items())->collection),
            'lastPage' => $paginated->lastPage(),
            'page' => $page,
        ]);
    }
    public function edit(Feature $feature)
    {
        return Inertia::render('Feature/Edit', [
            'feature' => new FeatureResource($feature)
        ]);
    }
    public function update(Request $request, Feature $feature)
    {
        $data = $request->validate([
            'name' => ['string', 'required'],
            'description' => ['string', 'nullable']
        ]);
        $feature->update($data);
        return to_route('features.index')->with('success', 'Feature updated successfully');

    }
    public function destroy(Feature $feature)
    {
        if ($feature->user_id !== auth()->id()) {
            abort(403);
        }
        $feature->delete();
        return to_route('features.index')->with('success', 'Feature has been deleted succesfully');

    }
}
