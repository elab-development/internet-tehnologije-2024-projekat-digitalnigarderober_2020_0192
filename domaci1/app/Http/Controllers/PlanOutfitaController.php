<?php

namespace App\Http\Controllers;

use App\Models\PlanOutfita;
use App\Http\Resources\PlanOutfitaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
            'lokacija' => 'required|string|max:255',
            'dogadjaj' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Dohvaćanje vremenske prognoze
        $vremenska_prognoza = $this->getWeatherForecast($request->lokacija);

        $plan = PlanOutfita::create([
            'naziv' => $request->naziv,
            'datum' => $request->datum,
            'lokacija' => $request->lokacija,
            'vremenska_prognoza' => $vremenska_prognoza,
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
            'lokacija' => 'required|string|max:255',
            'dogadjaj' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Dohvaćanje vremenske prognoze
        $vremenska_prognoza = $this->getWeatherForecast($request->lokacija);

        $plan->update([
            'naziv' => $request->naziv,
            'datum' => $request->datum,
            'lokacija' => $request->lokacija,
            'vremenska_prognoza' => $vremenska_prognoza,
            'dogadjaj' => $request->dogadjaj,
        ]);

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

    /**
     * Dohvaćanje vremenske prognoze pomoću WeatherAPI.
     */
    private function getWeatherForecast($lokacija)
    {
        try {
            //https://www.weatherapi.com/
            $apiKey ="8a1f9c9a5564423ba3e122001240712"; 

            // Primer poziva: https://api.weatherapi.com/v1/current.json?key=API_KEY&q=Belgrade&aqi=no
            $weatherResponse = Http::get("https://api.weatherapi.com/v1/current.json", [
                'key' => $apiKey,
                'q' => $lokacija,
                'aqi' => 'no'
            ]);

            \Log::info('WeatherAPI Response:', [
                'status' => $weatherResponse->status(),
                'body' => $weatherResponse->body(),
            ]);

            if ($weatherResponse->ok()) {
                $data = $weatherResponse->json();
                if (isset($data['current'])) {
                    $temp = $data['current']['temp_c'];
                    $description = $data['current']['condition']['text'];
                    return "Temperatura: {$temp}°C, Vreme: {$description}";
                }
            }

            return 'N/A';
        } catch (\Exception $e) {
            \Log::error('Weather API Error', ['message' => $e->getMessage()]);
            return 'N/A';
        }
    }
}
