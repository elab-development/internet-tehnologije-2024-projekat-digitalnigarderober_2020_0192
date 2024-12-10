<?php

namespace App\Http\Controllers;

use App\Models\Odeca;
use App\Http\Resources\OdecaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'slika' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Validacija za sliku
            'garderober_id' => 'required|exists:garderobers,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Upload slike
        if ($request->hasFile('slika')) {
            $data['slika'] = $request->file('slika')->store('slike', 'public'); // Čuva sliku u storage/app/public/slike
        }

        $odeca = Odeca::create($data);

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
            'slika' => 'nullable|file|mimes:jpg,jpeg,png|max:2048', // Validacija za sliku
            'garderober_id' => 'required|exists:garderobers,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Provera i upload nove slike
        if ($request->hasFile('slika')) {
            // Brišemo staru sliku ako postoji
            if ($odeca->slika && Storage::exists('public/' . $odeca->slika)) {
                Storage::delete('public/' . $odeca->slika);
            }

            $data['slika'] = $request->file('slika')->store('slike', 'public'); // Čuva novu sliku
        }

        $odeca->update($data);

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

        // Brišemo sliku iz storage-a ako postoji
        if ($odeca->slika && Storage::exists('public/' . $odeca->slika)) {
            Storage::delete('public/' . $odeca->slika);
        }

        $odeca->delete();

        return response()->json(['message' => 'Odeća je uspešno obrisana.']);
    }
}
