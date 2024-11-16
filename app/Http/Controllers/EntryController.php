<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use Illuminate\Http\Request;

class EntryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'national_number' => 'required|string'
        ]);

        $entry = Barcode::create([
            'national_number' => $request->national_number
        ]);

        return response()->json($entry, 201);
    }

    public function index()
    {
        return Barcode::latest()->get();
    }
}
