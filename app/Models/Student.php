<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class Student extends Model
{
    use HasFactory;
     protected $fillable = ['first_name','last_name', 'gender' , 'birth_date'];

    }
