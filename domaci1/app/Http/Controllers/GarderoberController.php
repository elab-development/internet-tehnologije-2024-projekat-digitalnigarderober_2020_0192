<?php

namespace App\Http\Controllers;

use App\Models\Garderober;
use App\Http\Resources\GarderoberResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GarderoberController extends Controller
{
    /**
     * Prikaz svih garderobera.
     */
    public function index()
    {
        $garderoberi = Garderober::where('user_id', auth()->id())->get();
        return response()->json(GarderoberResource::collection($garderoberi));
    }

    /**
     * Prikaz pojedinačnog garderobera.
     */
    public function show($id)
    {
        $garderober = Garderober::where('user_id', auth()->id())->findOrFail($id);
        return response()->json(new GarderoberResource($garderober));
    }

    /**
     * Kreiranje novog garderobera.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'naziv' => 'required|string|max:255',
            'opis' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $garderober = Garderober::create([
            'naziv' => $request->naziv,
            'opis' => $request->opis,
            'user_id' => auth()->id(),
        ]);

        return response()->json(new GarderoberResource($garderober), 201);
    }

    /**
     * Ažuriranje postojećeg garderobera.
     */
    public function update(Request $request, $id)
    {
        $garderober = Garderober::where('user_id', auth()->id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'naziv' => 'required|string|max:255',
            'opis' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $garderober->update($request->only(['naziv', 'opis']));

        return response()->json(new GarderoberResource($garderober));
    }

    /**
     * Brisanje garderobera.
     */
    public function destroy($id)
    {
        $garderober = Garderober::where('user_id', auth()->id())->findOrFail($id);
        $garderober->delete();

        return response()->json(['message' => 'Garderober je uspešno obrisan.']);
    }
}
