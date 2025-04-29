<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_section');
    }

    use HasFactory;

    protected $fillable = ['title'];

    public function students()
    {
        return $this->hasMany(Student::class, 'sections');
    }
}

