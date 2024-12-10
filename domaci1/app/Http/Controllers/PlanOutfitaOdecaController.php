<?php

namespace App\Http\Controllers;

use App\Models\PlanOutfita;
use App\Models\Odeca;
use Illuminate\Http\Request;

class PlanOutfitaOdecaController extends Controller
{
    /**
     * Dodavanje komada odeće u plan outfita.
     */
    public function addClothingItem(Request $request, $planOutfitId)
    {
        $plan = PlanOutfita::where('user_id', auth()->id())->findOrFail($planOutfitId);

        $request->validate([
            'clothing_item_id' => 'required|exists:odecas,id',
        ]);

        $clothingItemId = $request->input('clothing_item_id');

        // Proverava da li je odeća već povezana sa planom
        if ($plan->odeca()->where('odecas.id', $clothingItemId)->exists()) {
            return response()->json(['message' => 'Ova odeća je već dodata u plan.'], 422);
        }
        

        $plan->odeca()->attach($clothingItemId);

        return response()->json(['message' => 'Odeća je uspešno dodata u plan.']);
    }

    /**
     * Brisanje komada odeće iz plana outfita.
     */
    public function removeClothingItem($planOutfitId, $clothingItemId)
    {
        $plan = PlanOutfita::where('user_id', auth()->id())->findOrFail($planOutfitId);

        // Proverava da li je odeća povezana sa planom
        if (!$plan->odeca()->where('odecas.id', $clothingItemId)->exists()) {
            return response()->json(['message' => 'Ova odeća nije povezana sa planom.'], 404);
        }

        $plan->odeca()->detach($clothingItemId);

        return response()->json(['message' => 'Odeća je uspešno uklonjena iz plana.']);
    }

    /**
     * Prikaz svih komada odeće u planu outfita.
     */
    public function showClothingItems($planOutfitId)
    {
        $plan = PlanOutfita::where('user_id', auth()->id())->with('odeca')->findOrFail($planOutfitId);

        return response()->json([
            'plan' => new \App\Http\Resources\PlanOutfitaResource($plan),
        ]);
    }
}
