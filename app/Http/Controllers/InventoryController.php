<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    public function show($id)
    {
        $inventory = Inventory::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $inventory,
            'message' => 'Data inventaris berhasil diambil'
        ]);
    }
    
    public function index()
    {
        $inventories = Inventory::all();

        return response()->json([
            'status' => true,
            'data' => $inventories,
            'message' => 'Data inventaris berhasil diambil'
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
            $message = 'Stok barang berhasil ditambahkan';
        } else {
            $inventory = Inventory::create($request->all());
            $message = 'Inventaris berhasil ditambahkan';
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
            'stock' => 'required',
            'price' => 'required',
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update($request->all());

        return response()->json([
            'status' => 'true',
            'data' => ['id' => $inventory->id],
            'message' => 'Inventaris berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return response()->json([
            'status' => 'true',
            'data' => null,
            'message' => 'Inventaris berhasil dihapus'
        ]);
    }

}
