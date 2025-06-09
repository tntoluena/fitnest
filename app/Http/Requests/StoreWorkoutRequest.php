<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkoutRequest extends FormRequest
{
    public function authorize(): bool
    {
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
            'activity_name'    => ['required', 'string', 'max:255'],
            'duration_minutes' => ['required', 'integer', 'min:1'], 
            'calories_burned'  => ['required', 'integer', 'min:0'],
            'activity_type'    => ['nullable', 'string', 'max:100'],
            'log_date'         => ['required', 'date_format:Y-m-d'], 
        ];
    }
}