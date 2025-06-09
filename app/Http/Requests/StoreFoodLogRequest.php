<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFoodLogRequest extends FormRequest
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
            'food_name'      => ['required', 'string', 'max:255'],
            'calories'       => ['required', 'integer', 'min:0'],
            'protein'        => ['required', 'numeric', 'min:0'],
            'fat'            => ['required', 'numeric', 'min:0'],
            'carbs'          => ['required', 'numeric', 'min:0'],
            'meal_type'      => ['required', Rule::in(['breakfast', 'lunch', 'dinner', 'snack'])],
            'log_date'       => ['required', 'date_format:Y-m-d'], 
        ];
    }
}