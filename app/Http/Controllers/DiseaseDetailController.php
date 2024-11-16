<?php

namespace App\Http\Controllers;

use App\Models\DiseaseDetail;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DiseaseDetailController extends Controller
{
    /**
     * Get all disease details
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $diseaseDetails = DiseaseDetail::all();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Disease details retrieved successfully',
                'data' => $diseaseDetails
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve disease details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get disease details by name
     *
     * @param Request $request
     * @param string $name
     * @return JsonResponse
     */
    public function show(Request $request, string $name): JsonResponse
    {
        try {
            // Decode the URL-encoded name
            $decodedName = urldecode($name);
            
            $diseaseDetails = DiseaseDetail::where('name', 'LIKE', "%{$decodedName}%")->get();

            if ($diseaseDetails->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Disease details not found'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Disease details retrieved successfully',
                'data' => $diseaseDetails
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve disease details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get disease details by status
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function status(Request $request): JsonResponse
    {
        try {
            $status = $request->query('risk');
            
            if (!in_array($status, ['Low Risk', 'High Risk'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid status. Status must be either "Low Risk" or "High Risk"'
                ], 422);
            }

            $diseaseDetails = DiseaseDetail::where('status', $status)->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Disease details retrieved successfully',
                'data' => $diseaseDetails
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve disease details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}