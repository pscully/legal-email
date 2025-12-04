<?php

namespace App\Http\Controllers;

use App\Models\Invitee;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WebhookController extends Controller
{
    /**
     * Handle WordPress signup acceptance webhook.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function signupAccepted(Request $request): JsonResponse
    {
        // Validate the incoming request. Let validation exceptions bubble
        // so Laravel can return a 422 response for invalid input.
        $request->validate([
            'signup_code' => 'required|string',
        ]);

        // Find the invitee by signup code
        $invitee = Invitee::where('signup_code', $request->signup_code)->first();

        if ($invitee) {
            // Mark the invitee as accepted using the existing model method
            $invitee->markAsAccepted();

            return response()->json([
                'success' => true,
                'message' => 'Invitee marked as accepted'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invitee not found with the provided signup code'
        ], 404);
    }
}
