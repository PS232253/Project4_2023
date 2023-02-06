<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winkelwagen extends Model
{
    use HasFactory;
    protected $fillable = [ //onthoudt de stuks,user_id en pizza_id
        'stuks',
        'user_id',
        'pizza_id'];

    public function pizza()
    {
        //de "belongsTo" methode is de naam van de foreign key veld in het huidige model 
        //dat verwijst naar het primaire sleutelveld in het "Pizza" model.
        return $this->belongsTo(Pizza::class, 'pizza_id');
        //Op deze manier kun je gegevens ophalen van het gerelateerde model 
        //door te navigeren via de relatie en de naam van de functie te gebruiken
    }
}
