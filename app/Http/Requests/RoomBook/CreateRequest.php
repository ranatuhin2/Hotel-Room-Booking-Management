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
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ];
    }

    public function messages()
    {
        return [
            'room_id.required'   => 'Please select a room.',
            'room_id.exists'     => 'The selected room does not exist.',
            'check_in.required'  => 'Please select a check-in date.',
            'check_in.date'      => 'The check-in date must be a valid date.',
            'check_in.after_or_equal' => 'The check-in date must be today or later.',
            'check_out.required' => 'Please select a check-out date.',
            'check_out.date'     => 'The check-out date must be a valid date.',
            'check_out.after'    => 'The check-out date must be after the check-in date.',
        ];
    }
}
