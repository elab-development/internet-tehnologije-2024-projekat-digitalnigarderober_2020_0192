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
            'lokacija' => 'required|string|max:255', // Lokacija je obavezna za vremensku prognozu
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
            'lokacija' => 'required|string|max:255', // Lokacija je obavezna za vremensku prognozu
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
     * Dohvaćanje vremenske prognoze iz OpenWeatherMap API-ja.
     */
    private function getWeatherForecast($lokacija)
    {
        try {
            $apiKey = env('OPENWEATHER_API_KEY');
            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $lokacija,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'en',
            ]);

            if ($response->ok()) {
                $data = $response->json();
                return "Temperature: {$data['main']['temp']}°C, Weather: {$data['weather'][0]['description']}";
            }

            return 'N/A';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }
}
