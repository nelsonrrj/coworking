<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'reservation_status',
        'start_at',
        'end_at',
        'user_id',
        'office_id'
    ];
}
