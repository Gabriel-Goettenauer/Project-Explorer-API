<?php

namespace App\Http\Controllers;

use App\Models\Explorer;
use Illuminate\Http\Request;

class ExplorerController extends Controller
{
    public function store(Request $request)
    {
        $explorer = Explorer::create($request->all());
        return response()->json($explorer, 201);
    }

    public function updateLocation(Request $request, $id)
    {
        $explorer = Explorer::findOrFail($id);
        $explorer->update($request->only(['latitude', 'longitude']));
        return response()->json($explorer, 200);
    }

    public function showExplorers($id)
    {
        $explorer = Explorer::findOrFail($id);
        return response()->json($explorer, 200);
    }
}