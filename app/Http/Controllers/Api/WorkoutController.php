<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkoutRequest; 
use App\Models\Workout;                     
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;       


class WorkoutController extends Controller
{
    
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'sometimes|date_format:Y-m-d'
        ]);

        $logDate = $request->input('date', now()->toDateString());

        $workouts = Auth::user()->workouts() 
                          ->whereDate('log_date', $logDate)
                          ->get();

        return response()->json($workouts);
    }

    public function store(StoreWorkoutRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $validatedData['user_id'] = Auth::id();

        $workout = Workout::create($validatedData);

        return response()->json([
            'message' => 'Catatan workout berhasil disimpan!',
            'data'    => $workout
        ], 201); 
    }

    public function show(string $id)
    {

    }

    public function update(StoreWorkoutRequest $request, Workout $workout): JsonResponse
    {
        $this->authorize('update', $workout);

        $validatedData = $request->validated();

        $workout->update($validatedData);

        return response()->json([
            'message' => 'Catatan workout berhasil diperbarui!',
            'data'    => $workout
        ]);
    }

    public function destroy(Workout $workout): JsonResponse
    {
        $this->authorize('delete', $workout);

        $workout->delete();

        return response()->json([
            'message' => 'Catatan workout berhasil dihapus!'
        ]);
    }
}