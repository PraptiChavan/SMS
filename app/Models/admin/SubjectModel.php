<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectModel extends Model
{
    use HasFactory;

    // Define the table name explicitly
    protected $table = 'subjects';

    protected $fillable = [
        'name',
        'classes',
        'sections',
    ];

    // Accessor to retrieve class value
    public function getClassesAttribute($value)
    {
        return $value; // Return the single class value
    }

    // Mutator to store class value
    public function setClassesAttribute($value)
    {
        $this->attributes['classes'] = $value; // Store the single class value
    }

    // Accessor to retrieve section value
    public function getSectionsAttribute($value)
    {
        return $value; // Return the single section value
    }

    // Mutator to store section value
    public function setSectionsAttribute($value)
    {
        $this->attributes['sections'] = $value; // Store the single section value
    }
}
