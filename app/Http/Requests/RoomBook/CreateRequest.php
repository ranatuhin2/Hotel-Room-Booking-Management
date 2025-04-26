<?php

namespace App\Http\Requests\RoomBook;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'room_id' => 'required|exists:rooms,id',
            // 'date_range' => 'required|date|after_or_equal:today',
        ];
    }

    public function messages()
    {
        return [
            'room_id.required'   => 'Please select a room.',
            'room_id.exists'     => 'The selected room does not exist.',
            // 'date_range.required'  => 'Please select a check-in date.',
            // 'date_range.date'      => 'The check-in date must be a valid date.',
            // 'date_range.after_or_equal' => 'The check-in date must be today or later.',
        ];
    }
}
