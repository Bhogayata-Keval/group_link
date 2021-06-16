<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    //
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : 10;
        $result = Tag::paginate($limit);
        return response()->json($result, 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags,name',
            'description' => 'required',
        ]);

        Tag::create([
            'name' => request('name'),
            'description' => request('description'),
        ]);

        $message = array('message' => 'Tag Added Successfully');
        return response()->json($message);
    }
}
