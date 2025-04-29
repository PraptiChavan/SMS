<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodModel extends Model
{
    use HasFactory;

    protected $table = 'periods';

    protected $fillable = [
        'title',
        'from',
        'to',
    ];

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'period_id');
    }

    public function tattendance()
    {
        return $this->hasMany(TAttendance::class, 'period_id');
    }
}
