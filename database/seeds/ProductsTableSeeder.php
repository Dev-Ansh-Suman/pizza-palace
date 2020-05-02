<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
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
				'title' => 'Margherita',
				'add_ups' => 'Tomato sauce, mozzarella, and oregano',
				'image_url' => '/product-images/pizza-1.jpg',
				'slug' => 'margherita-pizza',
				'selling_price' => 28
			],[
				'title' => 'Marinara',
				'add_ups' => 'Tomato sauce, garlic and basil',
				'image_url' => '/product-images/pizza-2.jpg',
				'slug' => 'marinara-pizza',
				'selling_price' => 32
			],[
				'title' => 'Quattro Stagioni',
				'add_ups' => 'Mushrooms, ham, olives, and oregano',
				'image_url' => '/product-images/pizza-3.jpg',
				'slug' => 'quattro-stagioni-pizza',
				'selling_price' => 39
			],[
				'title' => 'Carbonara',
				'add_ups' => 'Mozzarella, eggs, and bacon',
				'image_url' => '/product-images/pizza-4.jpg',
				'slug' => 'carbonara-pizza',
				'selling_price' => 45
			],[
				'title' => 'Frutti di Mare',
				'add_ups' => 'Tomato sauce and seafood',
				'image_url' => '/product-images/pizza-5.jpg',
				'slug' => 'frutti-di-mare-pizza',
				'selling_price' => 49
			],[
				'title' => 'Quattro Formaggi',
				'add_ups' => 'Parmesan, artichokes, and oregano',
				'image_url' => '/product-images/pizza-6.jpg',
				'slug' => 'quattro-formaggi-pizza',
				'selling_price' => 21
			],[
				'title' => 'Crudo',
				'add_ups' => 'Mozzarella and Parma ham',
				'image_url' => '/product-images/pizza-7.jpg',
				'slug' => 'crudo-pizza',
				'selling_price' => 35
			],[
				'title' => 'Napoletana',
				'add_ups' => 'Mozzarella, oregano, anchovies',
				'image_url' => '/product-images/pizza-8.jpg',
				'slug' => 'napoletana-pizza',
				'selling_price' => 19
			],[
				'title' => 'Cruncy Cops',
				'add_ups' => 'Parmesan, oregano and Parma ham',
				'image_url' => '/product-images/pizza-9.jpg',
				'slug' => 'cruncy-cops-pizza',
				'selling_price' => 12
			]
        ]);
    }
}
