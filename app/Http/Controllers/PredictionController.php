<?php

namespace App\Http\Controllers;

use App\Models\HeartDiseasePrediction;
use App\Models\StrokePrediction;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PredictionController extends Controller
{
    public function getPredictionProgress(Request $request)
{
    try {
        // Set default date range to last 7 days if no input
        $endDate = $request->input('end_date', now()->format('Y-m-d H:i:s'));
        $startDate = $request->input('start_date', now()->subDays(7)->format('Y-m-d H:i:s'));

        // Validate date format
        $validatedData = $request->validate([
            'start_date' => 'nullable|date_format:Y-m-d H:i:s',
            'end_date' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:start_date',
            'type' => 'nullable|string|in:heart_disease,stroke,patient'  
        ]);

        // Get the type from the request, default to 'all' if not provided
        $type = $request->input('type', 'all');

        // Retrieve predictions based on the type
        if ($type === 'heart_disease') {
            $predictions = $this->fetchHeartDiseasePredictions($startDate, $endDate);
        } elseif ($type === 'stroke') {
            $predictions = $this->fetchStrokePredictions($startDate, $endDate);
        } elseif ($type === 'patient') {
            $predictions = $this->fetchPatientPredictions($startDate, $endDate);
        } else {
            // If no specific type, fetch all predictions
            $heartPredictions = $this->fetchHeartDiseasePredictions($startDate, $endDate);
            $strokePredictions = $this->fetchStrokePredictions($startDate, $endDate);
            $patientPredictions = $this->fetchPatientPredictions($startDate, $endDate);

            // Combine all predictions
            $predictions = collect([])
                ->concat($heartPredictions)
                ->concat($strokePredictions)
                ->concat($patientPredictions);
        }

        // Format predictions
        $allPredictions = $this->formatPredictions($predictions, $type);

        // Calculate statistics
        $statistics = $this->calculateStatistics($allPredictions);

        // Prepare response
        $response = [
            'request_parameters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'type' => $type
            ],
            'data_counts' => [
                'total' => $allPredictions->count()
            ],
            'timeline' => [
                'data' => $allPredictions,
                'total_records' => $allPredictions->count()
            ],
            'statistics' => $statistics,
            'latest_predictions' => $this->getLatestPredictions($allPredictions)
        ];

        return response()->json($response);

    } catch (\Exception $e) {
        Log::error('Error in getPredictionProgress:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'error' => 'An error occurred while processing the request',
            'message' => $e->getMessage()
        ], 500);
    }

}


    private function fetchHeartDiseasePredictions($startDate, $endDate)
    {
        return HeartDiseasePrediction::with(['diseaseDetail:id,name,status,description'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function fetchStrokePredictions($startDate, $endDate)
    {
        return StrokePrediction::with(['diseaseDetail:id,name,status,description'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function fetchPatientPredictions($startDate, $endDate)
    {
        return Patient::with(['diseaseDetail:id,name,status,description'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    private function formatPredictions($predictions, $type)
    {
        return $predictions->map(function ($prediction) use ($type) {
            return [
                'id' => $prediction->id,
                'type' => $type,
                'disease_id' => $prediction->disease_id,
                'disease_detail' => $prediction->diseaseDetail ? [
                    'id' => $prediction->diseaseDetail->id,
                    'name' => $prediction->diseaseDetail->name,
                    'status' => $prediction->diseaseDetail->status,
                    'description' => $prediction->diseaseDetail->description
                ] : null,
                'risk_score' => $prediction->risk_score,
                'prediction' => $prediction->prediction,
                'risk_status' => $prediction->prediction,
                'created_at' => $prediction->created_at->format('Y-m-d H:i:s')
            ];
        });
    }

    private function calculateStatistics($predictions)
    {
        $byType = $predictions->groupBy('type')->map->count();
        $byRisk = $predictions->groupBy('risk_status')->map->count();
        
        return [
            'by_type' => [
                'heart_disease' => $byType['heart_disease'] ?? 0,
                'stroke' => $byType['stroke'] ?? 0,
                'patient' => $byType['patient'] ?? 0
            ],
            'by_risk_status' => [
                'high_risk' => $byRisk['High Risk'] ?? 0,
                'low_risk' => $byRisk['Low Risk'] ?? 0
            ],
            'timeline' => [
                'first_prediction' => $predictions->first()['created_at'] ?? null,
                'last_prediction' => $predictions->last()['created_at'] ?? null,
                'total_days' => $predictions->isNotEmpty() 
                    ? Carbon::parse($predictions->first()['created_at'])->diffInDays(Carbon::parse($predictions->last()['created_at'])) + 1 
                    : 0
            ]
        ];
    }

    private function getLatestPredictions($predictions)
    {
        return $predictions
            ->groupBy('type')
            ->map(function ($typePredictions) {
                return $typePredictions->sortByDesc('created_at')->first();
            })
            ->filter()
            ->values();
    }
}