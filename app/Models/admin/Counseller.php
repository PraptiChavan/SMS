<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Counseller extends Model
{
    use HasFactory;

    // Optional: Specify the table name (if it’s not named ‘counsellers’ by default)
    protected $table = 'accounts';

    // Allow mass-assignment for these fields
    protected $fillable = ['type', 'name', 'email', 'password'];

    // Enable timestamps if your table has 'created_at' and 'updated_at' columns
    public $timestamps = true;
}
