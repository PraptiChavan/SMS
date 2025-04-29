<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
    use HasFactory;

    protected $table = 'attendance'; // Define table name explicitly

    protected $fillable = ['student_id', 'period_id', 'date', 'status']; // Mass assignable fields

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function period()
    {
        return $this->belongsTo(PeriodModel::class, 'period_id');
    }
}
