<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Hanya user yang sudah login yang boleh update profil.
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Ini adalah aturan validasi yang benar untuk data profil kita.
        // Setiap field yang ingin Anda simpan HARUS ada di sini.
        return [
            'age'            => 'nullable|integer|min:15|max:100',
            'gender'         => ['nullable', 'string', Rule::in(['male', 'female'])],
            'height'         => 'nullable|integer|min:100|max:250',
            'weight'         => 'nullable|numeric|min:30|max:250',
            'activity_level' => ['nullable', 'string', Rule::in(['sedentary', 'light', 'moderate', 'active', 'very_active'])],
            'calorie_goal'   => 'nullable|integer|min:1000|max:10000',
        ];
    }
}