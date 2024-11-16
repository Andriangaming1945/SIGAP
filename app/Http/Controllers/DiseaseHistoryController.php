<?php

namespace App\Http\Controllers;

use App\Models\DiseaseHistory;
use App\Models\CheckupHistory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DiseaseHistoryController extends Controller
{
    /**
     * Get disease history for a specific year
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getDiseaseHistory(Request $request): JsonResponse
    {
        try {
            $year = $request->query('year', date('Y'));
            $userId = auth()->id();

            $diseases = DiseaseHistory::where('user_id', $userId)
                ->where('year', $year)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Disease history retrieved successfully',
                'data' => $diseases
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve disease history',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get checkup history for a specific year
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCheckupHistory(Request $request): JsonResponse
    {
        try {
            $year = $request->query('year', date('Y'));
            $userId = auth()->id();

            $checkups = CheckupHistory::where('user_id', $userId)
                ->where('year', $year)
                ->orderBy('date', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Checkup history retrieved successfully',
                'data' => $checkups
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve checkup history',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
