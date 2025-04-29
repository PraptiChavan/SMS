<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamForm extends Model
{
    use HasFactory;

    protected $table = 'examform'; // Explicitly define table name
    protected $fillable = [
        'name',
        'classes',
        'subjects',
        'date',
        'start_time',
        'end_time',
        'total_marks',
    ];
}
