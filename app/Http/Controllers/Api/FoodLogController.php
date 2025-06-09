<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFoodLogRequest;
use App\Models\FoodLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class FoodLogController extends Controller
{
    use AuthorizesRequests; 

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'sometimes|date_format:Y-m-d'
        ]);

        $logDate = $request->input('date', now()->toDateString());

        $foodLogs = Auth::user()->foodLogs()
                              ->whereDate('log_date', $logDate)
                              ->get();

        return response()->json($foodLogs);
    }

    public function store(StoreFoodLogRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::id();
        $foodLog = FoodLog::create($validatedData);

        return response()->json([
            'message' => 'Catatan makanan berhasil disimpan!',
            'data' => $foodLog
        ], 201);
    }

    public function show(FoodLog $foodLog)
    {
        
    }

    public function update(StoreFoodLogRequest $request, FoodLog $foodLog): JsonResponse
    {
        $this->authorize('update', $foodLog);
        $validatedData = $request->validated();
        $foodLog->update($validatedData);

        return response()->json([
            'message' => 'Catatan makanan berhasil diperbarui!',
            'data' => $foodLog
        ]);
    }

    public function destroy(FoodLog $foodLog): JsonResponse
    {
        $this->authorize('delete', $foodLog);
        $foodLog->delete();

        return response()->json([
            'message' => 'Catatan makanan berhasil dihapus!'
        ]);
    }
}