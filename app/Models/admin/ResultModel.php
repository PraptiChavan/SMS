<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultModel extends Model {
    use HasFactory;

    protected $table = 'results'; // Define table name explicitly

    protected $fillable = [
        'student_name',
        'results',
        'subjects',
        'classes',
        'sections',
        'exam_name',
        'total_marks',
        'obtained_marks',
        'grade',
        'percentage',
    ]; // Mass assignable fields
    
    public function subject()
    {
        return $this->belongsTo(SubjectModel::class, 'subjects'); 
        // Assuming 'subjects' stores subject IDs
    }
    
    public function exam()
    {
        return $this->belongsTo(ExamForm::class, 'exam_name', 'id'); 
        // Assuming 'exam_name' holds exam ID
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'classes');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'sections');
    }
}
