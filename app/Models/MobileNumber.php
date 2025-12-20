<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'owner_type',
        'phone_number',
    ];

    public function owner()
    {
        return $this->morphTo();
    }
}
