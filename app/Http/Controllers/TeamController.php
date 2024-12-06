<?php 

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('tutorProduct')->get();
        return response()->json($teams, 200);
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'tutor_product_id' => 'required|exists:tutor_products,id',
                'name' => 'required|string|max:255',
                'contact' => [
                    'required',
                    'string',
                    'max:50',
                    // Example regex for validating a phone number (can be adjusted as per your needs)
                    'regex:/^(\+?[1-9]{1,4}?)?(\([0-9]{3}\)|[0-9]{3})[ -]?[0-9]{3}[ -]?[0-9]{4}$/',
                ],
                'website' => 'required|url',
            ]);

            // Create the Team
            $team = Team::create($validated);

            // Return the created resource as JSON
            return response()->json($team, 201);
        } catch (ValidationException $e) {
            // Return validation errors as JSON
            return response()->json([
                'errors' => $e->errors(),
            ], 422); // 422 is the status code for Unprocessable Entity
        }
    }

    public function show($id)
    {
        $team = Team::with('tutorProduct')->find($id);

        if (!$team) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        return response()->json($team, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'tutor_product_id' => 'required|exists:tutor_products,id',
                'name' => 'required|string|max:255',
                'contact' => [
                    'required',
                    'string',
                    'max:50',
                    // Example regex for validating a phone number (can be adjusted as per your needs)
                    'regex:/^(\+?[1-9]{1,4}?)?(\([0-9]{3}\)|[0-9]{3})[ -]?[0-9]{3}[ -]?[0-9]{4}$/',
                ],
                'website' => 'required|url',
            ]);
            

            // Find the Team by ID
            $team = Team::find($id);

            if (!$team) {
                return response()->json(['message' => 'Team not found'], 404);
            }

            // Update the Team
            $team->update($validated);

            return response()->json($team, 200);
        } catch (ValidationException $e) {
            // Return validation errors as JSON
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        $team = Team::find($id);

        if (!$team) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        $team->delete();
        return response()->json(['message' => 'Team deleted successfully'], 200);
    }
}
