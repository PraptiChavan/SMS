<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    // Optional: Specify the table name
    protected $table = 'students';

    // Allow mass-assignment for these fields
    protected $fillable = ['id', 'name', 'dob', 'mobile', 'email', 'address', 'country', 'state', 'zip', 'father_name', 'father_mobile', 'father_email', 'mother_name', 'mother_mobile', 'mother_email', 'parents_address', 'parents_country', 'parents_state', 'parents_zip', 'school_name', 'previous_class', 'status', 'total_marks', 'obtain_marks', 'previous_percentage', 'classes', 'sections', 'stream', 'doa', 'payment_method', 'receipt_number', 'registration_fee'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'id');
    }

    public function parents()
    {
        return $this->hasMany(Account::class, 'student_id')->where('type', 'parent');
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




