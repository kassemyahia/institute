<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'section_id'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_grades')
            ->withPivot('score')
            ->withTimestamps();
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_subject')->withTimestamps();
    }

    public function grades()
    {
        return $this->hasMany(StudentGrade::class);
    }
}
