<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bestelling extends Model
{
    use HasFactory;
    protected $fillable = [ //onthoudt de user_id en totaal
        'user_id',
        'totaal'
    ];
}
