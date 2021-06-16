<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Http\Controllers\Controller;
use App\Models\Tag;

class GroupController extends Controller
{
    //
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : 10;
        $result = Group::paginate($limit);
        return response()->json($result, 200);
    }

    public function create(Request $request)
    {
        // 'link' => 'required|url|unique:groups,link',
        $request->validate([
            'name' => 'required',
            'link' => 'required|url',
            'description' => 'required',
            'platform_id' => 'required|exists:platforms,id',
            'tags' => 'array|min:1'
        ]);

        $group = Group::create([
            'key' => request('key'),
            'name' => request('name'),
            'link' => request('link'),
            'platform_id' => request('platform_id'),
            'description' => request('description'),
        ]);

        if ($request->has('tags')) {
            foreach (request('tags') as $tag) {
                $firstOrCreatedTag = Tag::firstOrCreate(
                    [
                        'name' => $tag['name'],
                        'description' => $tag['name']
                    ]
                );
                $firstOrCreatedTag->groups()->attach($group->id);
            }
        }

        $message = array('message' => 'Group Added Successfully');
        return response()->json($message);
    }
}
