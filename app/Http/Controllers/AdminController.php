<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Disease;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('role', 'user')->count();
        $totalPredictions = Prediction::count();
        $accuratePredictions = Prediction::where('prediction_result', true)->count();
        $totalDiseases = Disease::count();
        $updatedDiseases = Disease::whereNotNull('updated_at')->count();

        return response()->json([
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'totalPredictions' => $totalPredictions,
            'accuratePredictions' => $accuratePredictions,
            'totalDiseases' => $totalDiseases,
            'updatedDiseases' => $updatedDiseases
        ]);
    }

    /**
     * Display a listing of all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $users = User::paginate(10);

        return response()->json($users);
    }

    /**
     * Display a listing of all disease predictions.
     *
     * @return \Illuminate\Http\Response
     */
    public function predictions()
    {
        $predictions = Prediction::with('user')->paginate(10);

        return response()->json($predictions);
    }

    /**
     * Display a listing of all disease details.
     *
     * @return \Illuminate\Http\Response
     */
    public function diseaseDetails()
    {
        $diseaseDetails = Disease::paginate(10);

        return response()->json($diseaseDetails);
    }

    /**
     * Update a specific disease detail.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateDiseaseDetail(Request $request, $id)
    {
        $disease = Disease::findOrFail($id);
        $disease->update($request->all());

        return response()->json($disease, 200);
    }
}