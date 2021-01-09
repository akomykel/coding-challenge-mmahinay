<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eevent extends Model
{
    use HasFactory;

    protected $table = 'eevents';

    protected $fillable = [
        'event_title',
        'event_date_from',
        'event_date_to',
        'event_days'
    ];
}
