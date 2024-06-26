<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Explorer;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function store(Request $request, $explorerId)
    {
        $explorer = Explorer::findOrFail($explorerId);
        $item = new Item($request->all());
        $explorer->items()->save($item);
        return response()->json($item, 201);
    }

    public function tradeItemsExplorers(Request $request)
    {
        $explorerFrom = Explorer::findOrFail($request->input('from'));
        $explorerTo = Explorer::findOrFail($request->input('to'));
        $itemsFromExplorer = Item::find($request->input('items_from'));
        $itemsTo = Item::find($request->input('items_to'));

        $valueFromExplorer = $itemsFromExplorer->sum('value');
        $valueToExplorer = $itemsTo->sum('value');

        if ($valueFromExplorer != $valueToExplorer) {
            return response()->json(['error' => 'Precisa ter o mesmo valor'], 400);
        }

        foreach ($itemsFromExplorer as $item) {
            $item->explorer_id = $explorerTo->id;
            $item->save();
        }

        foreach ($itemsTo as $item) {
            $item->explorer_id = $explorerFrom->id;
            $item->save();
        }

        return response()->json(['message' => 'Troca feita com  sucesso'], 200);
    }

    public function getItemsByExplorer($explorerId)
    {
        $explorer = Explorer::findOrFail($explorerId);
        $items = $explorer->items;
        return response()->json($items, 200);
    }
}
