<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PlanOutfita extends Pivot
{
    protected $fillable = [
        'naziv',
        'datum',
        'lokacija',
        'vremenska_prognoza',
        'dogadjaj',
        'user_id',
    ];
}
