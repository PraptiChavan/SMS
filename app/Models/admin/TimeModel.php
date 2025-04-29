<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeModel extends Model
{
    use HasFactory;

    protected $table = 'time'; // Explicitly define the table name

    /**
     * Get classes as a string (comma-separated).
     */
    public function getClassesAttribute($value)
    {
        return $value ? $value : '';
    }

    /**
     * Set classes as a comma-separated string.
     */
    public function setClassesAttribute($value)
    {
        $this->attributes['classes'] = is_array($value) ? implode(',', $value) : $value;
    }

    /**
     * Repeat similar methods for all other fields.
     */

    public function getSectionsAttribute($value)
    {
        return $value ? $value : '';
    }

    public function setSectionsAttribute($value)
    {
        $this->attributes['sections'] = is_array($value) ? implode(',', $value) : $value;
    }

    public function getTeachersAttribute($value)
    {
        return $value ? $value : '';
    }

    public function setTeachersAttribute($value)
    {
        $this->attributes['teachers'] = is_array($value) ? implode(',', $value) : $value;
    }

    public function getSubjectsAttribute($value)
    {
        return $value ? $value : '';
    }

    public function setSubjectsAttribute($value)
    {
        $this->attributes['subjects'] = is_array($value) ? implode(',', $value) : $value;
    }

    public function getPeriodsAttribute($value)
    {
        return $value ? $value : '';
    }

    public function setPeriodsAttribute($value)
    {
        $this->attributes['periods'] = is_array($value) ? implode(',', $value) : $value;
    }

    public function getWeekdaysAttribute($value)
    {
        return $value ? $value : '';
    }

    public function setWeekdaysAttribute($value)
    {
        $this->attributes['weekdays'] = is_array($value) ? implode(',', $value) : $value;
    }
}
