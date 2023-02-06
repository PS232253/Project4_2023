<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable =['bestel_id', 'pizza_id', 'stuks']; //onthoudt de bestel_id, pizza_id en stuks
}
