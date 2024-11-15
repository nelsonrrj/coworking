<?php

namespace App\Http\Requests;

use App\Rules\AvailableReservationDateRule;

class StoreReservationRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'office_id' => ['required', 'exists:offices,id'],
            'start_at' => ['required', 'date', new AvailableReservationDateRule]
        ];
    }
}
