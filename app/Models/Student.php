<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'section_id',
        'stage_id',
        'is_fully_paid',
        'registration_date',
        'full_price',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'registration_date' => 'date',
        'is_fully_paid' => 'boolean',
        'full_price' => 'decimal:2',
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function grades()
    {
        return $this->hasMany(StudentGrade::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_grades')
            ->withPivot('score')
            ->withTimestamps();
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function getTotalPaidAttribute()
    {
        return $this->installments->sum('amount_paid');
    }

    public function getAmountLeftAttribute()
    {
        return max(0, ($this->full_price ?? 0) - $this->installments->sum('amount_paid'));
    }

    public function mobileNumbers()
    {
        return $this->morphMany(MobileNumber::class, 'owner');
    }
}
