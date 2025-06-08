<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFoodLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Karena route kita nanti akan dilindungi oleh middleware 'auth:sanctum',
        // kita bisa pastikan hanya pengguna terautentikasi yang bisa sampai sini.
        // Jadi, kita return true.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'food_name'      => ['required', 'string', 'max:255'],
            'calories'       => ['required', 'integer', 'min:0'],
            'protein'        => ['required', 'numeric', 'min:0'],
            'fat'            => ['required', 'numeric', 'min:0'],
            'carbs'          => ['required', 'numeric', 'min:0'],
            'meal_type'      => ['required', Rule::in(['breakfast', 'lunch', 'dinner', 'snack'])],
            'log_date'       => ['required', 'date_format:Y-m-d'], // Memastikan formatnya 'Tahun-Bulan-Tanggal'
        ];
    }
}