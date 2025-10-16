<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoringPercentage extends Model
{
    protected $table = 'scoring_percentage';
    protected $fillable = ['interview', 'gwa', 'skilltest', 'exam'];
}
