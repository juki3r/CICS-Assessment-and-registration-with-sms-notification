<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntranceExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'status',
    ];
}
