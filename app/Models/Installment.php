<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount_paid',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
