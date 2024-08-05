<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $inventory,
            'message' => 'Inventory data successfully retrieved by id'
        ]);
    }
    
    public function index()
    {
        $inventories = Inventory::all();

        return response()->json([
            'status' => true,
            'data' => $inventories,
            'message' => 'Inventory data successfully retrieved'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);
    
        
        $inventory = Inventory::where('name', $request->name)->first();
    
        if ($inventory) {
            $inventory->increment('quantity', $request->quantity);
            $inventory->increment('price', $request->price);
            $message = 'Stock and Price of the item successfully added';
        } else {
            $inventory = Inventory::create($request->all());
            $message = 'Inventory successfully added';
        }
    
        return response()->json([
            'status' => true,
            'data' => ['id' => $inventory->id],
            'message' => $message
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update($request->all());
        $userId = Auth::user()->id;

        return response()->json([
            'status' => 'true',
            'data' => [
                'id' => $inventory->id,
                'updated_by' => $userId
            ],
            'message' => 'Inventory updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return response()->json([
            'status' => 'true',
            'data' => null,
            'message' => 'Inventory deleted successfully'
        ]);
    }

}
