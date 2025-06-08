<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkoutRequest; // <-- 1. Import Form Request
use App\Models\Workout;                     // <-- 2. Import Model
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;       // <-- 3. Import Auth untuk mengambil data user


class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        // 1. Validasi sederhana untuk memastikan jika ada input 'date', formatnya benar
        $request->validate([
            'date' => 'sometimes|date_format:Y-m-d'
        ]);

        // 2. Ambil tanggal dari request. Jika tidak ada, gunakan tanggal hari ini.
        $logDate = $request->input('date', now()->toDateString());

        // 3. Ambil semua catatan workout milik pengguna yang sedang login
        //    lalu filter berdasarkan tanggal yang diberikan.
        $workouts = Auth::user()->workouts() // Memanfaatkan relasi 'workouts' di Model User (jika ada) atau query langsung
                          ->whereDate('log_date', $logDate)
                          ->get();

        // 4. Kembalikan data dalam bentuk JSON
        return response()->json($workouts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkoutRequest $request): JsonResponse
    {
        // Dengan menempatkan StoreWorkoutRequest di sini,
        // validasi dan otorisasi berjalan secara OTOMATIS.
        // Jika gagal, Laravel akan mengirim response error.
        // Jika berhasil, kode di bawah ini akan dijalankan.

        // a. Ambil data yang sudah lolos validasi
        $validatedData = $request->validated();

        // b. Tambahkan user_id dari pengguna yang sedang login
        $validatedData['user_id'] = Auth::id();
        // atau $validatedData['user_id'] = $request->user()->id;

        // c. Buat log workout baru menggunakan Model
        $workout = Workout::create($validatedData);

        // d. Kembalikan response JSON yang menandakan sukses
        return response()->json([
            'message' => 'Catatan workout berhasil disimpan!',
            'data'    => $workout
        ], 201); // 201 Created adalah status code yang tepat untuk POST request yang berhasil
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Akan kita isi nanti
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreWorkoutRequest $request, Workout $workout): JsonResponse
    {
        // 1. OTORISASI: Tanya "satpam" (Policy) dulu.
        // Baris ini akan memanggil metode 'update' di WorkoutPolicy.
        // Jika policy mengembalikan false, Laravel otomatis mengirim error 403 Forbidden.
        $this->authorize('update', $workout);

        // 2. VALIDASI: Berjalan otomatis karena kita menggunakan StoreWorkoutRequest.
        $validatedData = $request->validated();

        // 3. PROSES UPDATE: Jika lolos otorisasi dan validasi, update datanya.
        $workout->update($validatedData);

        // 4. RESPONSE: Kembalikan data yang sudah diupdate.
        return response()->json([
            'message' => 'Catatan workout berhasil diperbarui!',
            'data'    => $workout
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workout $workout): JsonResponse
    {
        // 1. OTORISASI: Tanya "satpam" (Policy) dulu.
        $this->authorize('delete', $workout);

        // 2. PROSES DELETE
        $workout->delete();

        // 3. RESPONSE: Kirim pesan sukses. Status 200 OK atau 204 No Content cocok di sini.
        return response()->json([
            'message' => 'Catatan workout berhasil dihapus!'
        ]);
    }
}