<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Promenjeno iz Pivot u Model

class PlanOutfita extends Model
{
    use HasFactory;

    protected $fillable = [
        'naziv',
        'datum',
        'lokacija',
        'vremenska_prognoza',
        'dogadjaj',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function odeca()
    {
        return $this->belongsToMany(Odeca::class, 'outfit_plan_clothing_item');
    }
}
