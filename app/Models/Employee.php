<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'job_title',
        'salary',
        'birth_date',
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'employee_subject')->withTimestamps();
    }

    public function mobileNumbers()
    {
        return $this->morphMany(MobileNumber::class, 'owner');
    }

}
