<?php

namespace App\Http\Requests\Room;

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
            'room_number' => 'required|unique:rooms,room_number|max:10',
            'type'        => 'required|in:single,double',
            'price'       => 'required|numeric|min:0',
            'status'      => 'required|in:available,booked',
        ];
    }


    public function messages(): array
    {
        return [
            'room_number.required' => 'Room number is required.',
            'room_number.unique'   => 'This room number already exists.',
            'type.required'        => 'Please select a room type.',
            'price.required'       => 'Price is required.',
            'status.required'      => 'Please select room status.',
        ];
    }
}
