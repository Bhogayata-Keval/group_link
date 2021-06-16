<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Platform;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class PlatformController extends Controller
{
    //
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : 10;
        $result = Platform::paginate($limit);
        return response()->json($result, 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:platforms,key',
            'name' => 'required|unique:platforms,name',
            'description' => 'required',
            'icon' => 'required|mimes:jpeg,jpg,png'
        ]);

        if ($request->hasfile('icon')) {
            $file = $request->file('icon');
            $icon_name = time() . '_' . Str::random(6) . '.' . $file->extension();
            $file->move(public_path() . '/images/', $icon_name);
        }

        $platform = Platform::create([
            'key' => request('key'),
            'name' => request('name'),
            'icon' => $icon_name,
            'description' => request('description'),
        ]);

        $message = array('message' => 'Platform Added Successfully');
        return response()->json($message);
    }
}
