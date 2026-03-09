<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmitModel extends Model {

    use HasFactory;

    protected $table = 'admitcards';

    protected $fillable = [
        'student_name',
        'fees_paid',
        'admit_card',
        'classes',
        'sections',
    ];

    /*
    |--------------------------------------------------------------------------
    | Check if admit card already generated
    |--------------------------------------------------------------------------
    */
    public static function alreadyGenerated($studentName, $classId, $sectionId)
    {
        return self::where('student_name', $studentName)
            ->where('classes', $classId)
            ->where('sections', $sectionId)
            ->exists();
    }

}