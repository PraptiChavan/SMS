<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TAttendance extends Model {
    use HasFactory;

    protected $table = 'tattendance'; // Explicitly defining table name

    protected $fillable = ['teacher_id', 'date', 'status', 'period_id']; // Mass assignable fields

    public function teacher()
    {
        return $this->belongsTo(Account::class, 'teacher_id');
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id');
    }
}
