<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    // Optional: Specify the table name
    protected $table = 'accounts';

    // Allow mass-assignment for these fields
    protected $fillable = ['type', 'name', 'email', 'password', 'student_id'];

    // Enable timestamps if your table has 'created_at' and 'updated_at' columns
    public $timestamps = true; // Set to false if timestamps are not used

    public function student()
    {
        return Student::where('father_email', $this->email)
            ->orWhere('mother_email', $this->email)
            ->first();
    }
}




