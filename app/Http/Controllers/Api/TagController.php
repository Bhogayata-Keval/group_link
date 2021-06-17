<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagResource;

class TagController extends Controller
{
    //
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : 10;
        return TagResource::collection(Tag::paginate($limit));
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags,name',
            'description' => 'string|nullable',
        ]);

        $tag = Tag::create([
            'name' => request('name'),
            'description' => request('description'),
        ]);

        return new TagResource($tag);
    }
}
