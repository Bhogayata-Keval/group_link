<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Http\Controllers\Controller;
use App\Http\Resources\GroupResource;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        // TODO: Remove DEBUG
        var_dump(Auth::user());
        die();
        $limit = isset($request->limit) ? $request->limit : 10;
        $q = Group::query();
        if (isset($request->search) && $request->search != '' && $request->search != null && $request->search != 'null' && $request->search != 'NULL') {
            $q->where('name', 'like', "%{$request->search}%");
        }
        if (isset($request->platform)) {
            $q->whereHas('platform', function ($query) use ($request) {
                $query->where('name', $request->platform);
            });
        }
        if (isset($request->tags) && $request->tags !== '') {
            $q->whereHas('tags', function ($query) use ($request) {
                $query->whereIn('name', explode(",", $request->tags));
            });
        }
        return GroupResource::collection(
            $q->paginate($limit)
        );
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'link' => 'required|url|unique:groups,link',
            'description' => 'string|nullable',
            'platform_id' => 'required|exists:platforms,id',
            'tags' => 'array|min:1'
        ]);

        try {
            DB::beginTransaction();
            $group = Group::create([
                'key' => request('key'),
                'name' => request('name'),
                'link' => request('link'),
                'platform_id' => request('platform_id'),
                'description' => request('description'),
            ]);

            if ($request->has('tags')) {
                foreach (request('tags') as $tag) {
                    $firstOrNewTag = Tag::firstOrNew(
                        [
                            'name' => $tag['name']
                        ]
                    );
                    if (isset($tag['description'])) {
                        $firstOrNewTag->description = $tag['description'];
                    }
                    $firstOrNewTag->save();
                    $firstOrNewTag->groups()->attach($group->id);
                }
            }

            DB::commit();
            return new GroupResource($group);
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }
}
