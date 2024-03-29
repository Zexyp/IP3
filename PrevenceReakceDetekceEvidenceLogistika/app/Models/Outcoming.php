<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outcoming extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'mass',
        'worth',
        'checked',
    ];
}
