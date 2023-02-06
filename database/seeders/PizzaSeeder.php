<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pizzas')->insert([
            'naam' => 'pizza margherita',
            'image' => 'public/img/margherita.jpg',
            'prijs' => '5.00'

        ]);
        DB::table('pizzas')->insert([
            'naam' => 'pizza pepperoni',
            'image' => 'public/img/pepperoni.jpg',
            'prijs' => '5.00'

        ]);
        DB::table('pizzas')->insert([
            'naam' => 'pizza speciaal',
            'image' => 'public/img/special.jpg',
            'prijs' => '5.00'

        ]);
    }
}
