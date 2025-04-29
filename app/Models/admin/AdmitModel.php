<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmitModel extends Model {
    use HasFactory;

    protected $table = 'admitcards'; // Define table name explicitly

    protected $fillable = [
        'student_name',
        'fees_paid',
        'admit_card',
        'classes',
        'sections',
    ]; // Mass assignable fields

}
