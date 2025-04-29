<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeekdayModel extends Model
{
    use HasFactory;

    protected $table = 'weekdays';

    protected $fillable = [
        'weekdays',
    ];
}
