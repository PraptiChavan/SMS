<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes'; // Explicitly define table name
    protected $fillable = ['title', 'sections']; // Allow mass assignment for the 'title' column
    // Disable timestamps (created_at, updated_at)
    //public $timestamps = false;

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'sections'); // Many-to-Many relationship with sections
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'sections');
    }
}
