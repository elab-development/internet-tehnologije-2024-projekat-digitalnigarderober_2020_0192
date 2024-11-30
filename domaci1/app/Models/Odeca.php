<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odeca extends Model
{
    use HasFactory;
    protected $fillable = [
        'naziv',
        'tip',
        'boja',
        'sezona',
        'materijal',
        'slika',
        'garderober_id',
    ];
}
