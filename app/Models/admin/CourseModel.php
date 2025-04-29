<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModel extends Model
{
    use HasFactory;

    protected $table = 'courses'; // Explicitly define table name
    protected $fillable = [
        'name',
        'category',
        'duration',
        'date',
        'image',
    ]; // Allow mass assignment for the 'title' column
    // Disable timestamps (created_at, updated_at)
    public $timestamps = false;
}
