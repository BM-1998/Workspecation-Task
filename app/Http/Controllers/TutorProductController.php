<?php 

namespace App\Http\Controllers;

use App\Models\TutorProduct;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TutorProductController extends Controller
{
    public function index()
    {
        $tutorProducts = TutorProduct::with('teams')->get();
        return response()->json($tutorProducts, 200);
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            // Create the TutorProduct
            $tutorProduct = TutorProduct::create($validated);

            // Return the created resource as JSON
            return response()->json($tutorProduct, 201);
        } catch (ValidationException $e) {
            // Return validation errors as JSON
            return response()->json([
                'errors' => $e->errors(),
            ], 422); // 422 is the status code for Unprocessable Entity
        }
    }

    public function show($id)
    {
        $tutorProduct = TutorProduct::with('teams')->find($id);

        if (!$tutorProduct) {
            return response()->json(['message' => 'TutorProduct not found'], 404);
        }

        return response()->json($tutorProduct, 200);
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the incoming request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            // Find the TutorProduct by ID
            $tutorProduct = TutorProduct::find($id);

            if (!$tutorProduct) {
                return response()->json(['message' => 'TutorProduct not found'], 404);
            }

            // Update the TutorProduct
            $tutorProduct->update($validated);

            return response()->json($tutorProduct, 200);
        } catch (ValidationException $e) {
            // Return validation errors as JSON
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        }
    }

    public function destroy($id)
    {
        $tutorProduct = TutorProduct::find($id);

        if (!$tutorProduct) {
            return response()->json(['message' => 'TutorProduct not found'], 404);
        }

        $tutorProduct->delete();
        return response()->json(['message' => 'TutorProduct deleted successfully'], 200);
    }
}
