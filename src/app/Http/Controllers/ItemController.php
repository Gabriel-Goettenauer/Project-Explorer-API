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
        $explorerToWho = Explorer::findOrFail($request->input('to'));
        $itemsFromExplorer = Item::find($request->input('items_from'));
        $itemsToExplorer = Item::find($request->input('items_to'));

        $valueFromExplorer = $itemsFromExplorer->sum('value');
        $valueToExplorer = $itemsToExplorer->sum('value');

        if ($valueFromExplorer != $valueToExplorer) {
            return response()->json(['error' => 'Item precisa ter o mesmo valor'], 400);
        }

        foreach ($itemsFromExplorer as $item) {
            $item->explorer_id = $explorerToWho->id;
            $item->save();
        }

        foreach ($itemsToExplorer as $item) {
            $item->explorer_id = $explorerFrom->id;
            $item->save();
        }

        return response()->json(['message' => 'Troca feita com sucesso'], 200);
    }

    public function getItemsByExplorer($explorerId)
    {
        $explorer = Explorer::findOrFail($explorerId);
        $items = $explorer->items;
        return response()->json($items, 200);
    }
}
