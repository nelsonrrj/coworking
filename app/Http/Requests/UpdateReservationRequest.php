<?php

namespace App\Http\Requests;

use App\DataValues\ReservationStatus;
use Illuminate\Validation\Rule;

class UpdateReservationRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reservation_status' => ['required', Rule::in(ReservationStatus::getAll())],
        ];
    }
}
