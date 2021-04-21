<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Margherita',
                'details' => 'Ingredients: red tomatoes, white mozzarella cheese, and green basil',
                'price' => 19.50,
                'image' => 'https://cdn.tasteatlas.com/images/dishes/3b95e478a76a48a0897c6724d32e2509.jpg',
            ],
            [
                'name' => 'Calzone',
                'details' => 'Ingredients: tomato sauce, salami, mozzarella, ricotta and parmesan',
                'price' => 22.00,
                'image' => 'https://cdn.tasteatlas.com/images/dishes/2dd9d07402f9404bb1149da811a0c42d.jpg',
            ],
            [
                'name' => 'Marinara',
                'details' => 'Ingredients: tomatoes, oregano, garlic, extra virgin olive oil, and fresh basil',
                'price' => 20.00,
                'image' => 'https://cdn.tasteatlas.com/images/dishes/5560ca794b7d49f7bdbfc1c27d65b39d.jpg',
            ],
            [
                'name' => 'Pepperoni',
                'details' => 'Ingredients: tomato sauce, mozzarella, and pepperoni',
                'price' => 21.5,
                'image' => 'https://cdn.tasteatlas.com/images/dishes/b05a0af72ad845f3a6abe16143d7853a.jpg',
            ],
            [
                'name' => 'Chicago-style deep dish',
                'details' => 'Ingredients: mozzarella, meat, tomatoes and a crunchy crust',
                'price' => 24.00,
                'image' => 'https://cdn.tasteatlas.com/images/dishes/bbdd0eda6bfe473884814c4a1f3201a8.jpg',
            ],
            [
                'name' => 'Capricciosa',
                'details' => 'Ingredients: tomato sauce, mozzarella, mushrooms, artichokes, ham and olives',
                'price' => 24.00,
                'image' => 'https://cdn.tasteatlas.com/images/dishes/5789ac96790b4e27b6e8ca102f917b2c.jpg',
            ],
            [
                'name' => 'New York-Style',
                'details' => 'Ingredients: tomato sauce, mozzarella, mushrooms, olive oil, garlic, oregano, crushed red pepper and basil',
                'price' => 25.5,
                'image' => 'https://cdn.tasteatlas.com/Images/Dishes/da8ece52e2634d54b38513642dcbc4cd.jpg',
            ],
            [
                'name' => 'Caprese',
                'details' => 'Ingredients: cherry tomatoes, mozzarella di bufala, olive oil, and fresh basil leaves',
                'price' => 25.5,
                'image' => 'https://cdn.tasteatlas.com/Images/Dishes/5c9ef8900b4d4afc8313a2e282574b7f.jpg',
            ],
            [
                'name' => 'Quattro Formaggi',
                'details' => 'Ingredients: Mozzarella, Gorgonzola, Fontina, and Parmigiano-Reggiano',
                'price' => 25.5,
                'image' => 'https://cdn.tasteatlas.com/images/dishes/e6f2310a7ffe4904bc9826bfc77ee11f.jpg',
            ]
        ]);
    }
}
