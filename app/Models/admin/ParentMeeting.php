<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentMeeting extends Model {
    use HasFactory;

    protected $table = 'parents_meetings';
    protected $fillable = ['teacher_id', 'class_id', 'date', 'time', 'mode', 'agenda', 'status', 'meeting_link', 'status_updated_by'];

    public function teacher() {
        return $this->belongsTo(Account::class, 'teacher_id');
    }

    public function class() {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Account::class, 'status_updated_by');
    }

}

