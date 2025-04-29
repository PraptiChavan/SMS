<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMaterials extends Model
{
    use HasFactory;

    protected $table = 'studymaterials'; // Explicitly define table name
    protected $fillable = [
        'title',
        'attachment',
        'classes',
        'subjects',
        'date',
        'description',
    ];
}
