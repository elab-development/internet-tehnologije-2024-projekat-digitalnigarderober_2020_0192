<?php

namespace App\Http\Controllers;

use App\Models\PlanOutfita;
use App\Http\Resources\PlanOutfitaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlanOutfitaController extends Controller
{
    /**
     * Prikaz svih planova outfita.
     */
    public function index()
    {
        $planovi = PlanOutfita::where('user_id', auth()->id())->get();
        return response()->json(PlanOutfitaResource::collection($planovi));
    }

    /**
     * Prikaz pojedinačnog plana outfita.
     */
    public function show($id)
    {
        $plan = PlanOutfita::where('user_id', auth()->id())->findOrFail($id);
        return response()->json(new PlanOutfitaResource($plan));
    }

    /**
     * Kreiranje novog plana outfita.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'naziv' => 'required|string|max:255',
            'datum' => 'required|date',
            'lokacija' => 'nullable|string|max:255',
            'vremenska_prognoza' => 'nullable|string|max:255',
            'dogadjaj' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $plan = PlanOutfita::create([
            'naziv' => $request->naziv,
            'datum' => $request->datum,
            'lokacija' => $request->lokacija,
            'vremenska_prognoza' => $request->vremenska_prognoza,
            'dogadjaj' => $request->dogadjaj,
            'user_id' => auth()->id(),
        ]);

        return response()->json(new PlanOutfitaResource($plan), 201);
    }

    /**
     * Ažuriranje postojećeg plana outfita.
     */
    public function update(Request $request, $id)
    {
        $plan = PlanOutfita::where('user_id', auth()->id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'naziv' => 'required|string|max:255',
            'datum' => 'required|date',
            'lokacija' => 'nullable|string|max:255',
            'vremenska_prognoza' => 'nullable|string|max:255',
            'dogadjaj' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $plan->update($request->only(['naziv', 'datum', 'lokacija', 'vremenska_prognoza', 'dogadjaj']));

        return response()->json(new PlanOutfitaResource($plan));
    }

    /**
     * Brisanje plana outfita.
     */
    public function destroy($id)
    {
        $plan = PlanOutfita::where('user_id', auth()->id())->findOrFail($id);
        $plan->delete();

        return response()->json(['message' => 'Plan outfita je uspešno obrisan.']);
    }
}
