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
    public function garderober()
    {
        return $this->belongsTo(Garderober::class);
    }

 
    public function planoviOutfita()
    {
        return $this->belongsToMany(PlanOutfita::class, 'outfit_plan_clothing_item', 'clothing_item_id', 'plan_outfit_id');
    }
    

}
