<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Platform;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlatformResource;
use Illuminate\Support\Str;

class PlatformController extends Controller
{
    //
    public function index(Request $request)
    {
        $limit = isset($request->limit) ? $request->limit : 10;
        return PlatformResource::collection(Platform::paginate($limit));
    }

    public function create(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:platforms,key',
            'name' => 'required|unique:platforms,name',
            'description' => 'string|nullable',
            'icon' => 'mimes:jpeg,jpg,png'
        ]);

        $data = [
            'key' => request('key'),
            'name' => request('name'),
            'description' => request('description'),
        ];
        if ($request->hasfile('icon')) {
            $file = $request->file('icon');
            $icon_name = time() . '_' . Str::random(6) . '.' . $file->extension();
            $file->move(public_path() . '/images/', $icon_name);
            $data['icon'] = $icon_name;
        }

        $platform = Platform::create($data);
        return new PlatformResource($platform);
    }
}
