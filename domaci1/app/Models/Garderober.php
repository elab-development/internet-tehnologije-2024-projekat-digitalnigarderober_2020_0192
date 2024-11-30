<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garderober extends Model
{
    use HasFactory;

    protected $fillable = [
        'naziv',
        'opis',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function odeca()
    {
        return $this->hasMany(Odeca::class);
    }

}
