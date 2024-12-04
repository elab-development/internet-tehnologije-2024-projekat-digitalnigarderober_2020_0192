<?php

namespace App\Http\Controllers;

use App\Models\Odeca;
use App\Http\Resources\OdecaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OdecaController extends Controller
{
    /**
     * Prikaz svih odeća.
     */
    public function index()
    {
        $odeca = Odeca::whereHas('garderober', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return response()->json(OdecaResource::collection($odeca));
    }

    /**
     * Prikaz pojedinačne odeće.
     */
    public function show($id)
    {
        $odeca = Odeca::whereHas('garderober', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        return response()->json(new OdecaResource($odeca));
    }

    /**
     * Kreiranje nove odeće.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'naziv' => 'required|string|max:255',
            'tip' => 'required|string|max:255',
            'boja' => 'required|string|max:255',
            'sezona' => 'required|string|max:255',
            'materijal' => 'nullable|string|max:255',
            'slika' => 'nullable|url',
            'garderober_id' => 'required|exists:garderoberi,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $odeca = Odeca::create($request->all());

        return response()->json(new OdecaResource($odeca), 201);
    }

    /**
     * Ažuriranje postojeće odeće.
     */
    public function update(Request $request, $id)
    {
        $odeca = Odeca::whereHas('garderober', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'naziv' => 'required|string|max:255',
            'tip' => 'required|string|max:255',
            'boja' => 'required|string|max:255',
            'sezona' => 'required|string|max:255',
            'materijal' => 'nullable|string|max:255',
            'slika' => 'nullable|url',
            'garderober_id' => 'required|exists:garderoberi,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $odeca->update($request->all());

        return response()->json(new OdecaResource($odeca));
    }

    /**
     * Brisanje odeće.
     */
    public function destroy($id)
    {
        $odeca = Odeca::whereHas('garderober', function ($query) {
            $query->where('user_id', auth()->id());
        })->findOrFail($id);

        $odeca->delete();

        return response()->json(['message' => 'Odeća je uspešno obrisana.']);
    }
}
