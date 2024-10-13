<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Region;
use App\Models\District;
use App\Models\Ward;
use App\Models\Street;

class LocationController extends Controller
{
    public function getRegions()
    {
        $regions = Region::all();
        return response()->json($regions);
    }

    public function getDistricts($regionId)
    {
        $districts = District::where('region_id', $regionId)->get();
        return response()->json($districts);
    }

    public function getWards($districtId)
    {
        $wards = Ward::where('district_id', $districtId)->get();
        return response()->json($wards);
    }

    public function getStreets($wardId)
    {
        $streets = Street::where('ward_id', $wardId)->get();
        return response()->json($streets);
    }

    // ! ******* GOOGLE MAPS START HERE ************** ! //


    public function getLocation(Request $request) //? HII FUNCTION HAITUMIKI BADO
    {
        // Validate the request
        $request->validate([
            'latlng' => 'required|string'
        ]);
    
        try {
            // Make an HTTP GET request to the Google Maps Geocoding API
            $response = Http::post("https://maps.googleapis.com/maps/api/geocode/json", [
                'latlng' => $request->latlng,
                'key' => env('GOOGLE_MAPS_API_KEY'),
            ]);
    
            // Check if the response is successful
            if ($response->ok()) {
                $data = $response->json();
                $location = $data['results'][0]['formatted_address'] ?? 'Unknown location';
                $coordinates = $data['results'][0]['geometry']['location'] ?? ['lat' => 'Unknown', 'lng' => 'Unknown'];
    
                return response()->json([
                    'location' => $location,
                    'coordinates' => $coordinates,
                ]);
            } else {
                return response()->json(['error' => 'Unable to fetch location from Google Maps API.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
