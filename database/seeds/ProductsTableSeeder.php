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
				'selling_price' => 28,
				'selling_price_euro' => 25
			],[
				'title' => 'Marinara',
				'add_ups' => 'Tomato sauce, garlic and basil',
				'image_url' => '/product-images/pizza-2.jpg',
				'slug' => 'marinara-pizza',
				'selling_price' => 32,
				'selling_price_euro' => 29
			],[
				'title' => 'Quattro Stagioni',
				'add_ups' => 'Mushrooms, ham, olives, and oregano',
				'image_url' => '/product-images/pizza-3.jpg',
				'slug' => 'quattro-stagioni-pizza',
				'selling_price' => 39,
				'selling_price_euro' => 35
			],[
				'title' => 'Carbonara',
				'add_ups' => 'Mozzarella, eggs, and bacon',
				'image_url' => '/product-images/pizza-4.jpg',
				'slug' => 'carbonara-pizza',
				'selling_price' => 45,
				'selling_price_euro' => 40
			],[
				'title' => 'Frutti di Mare',
				'add_ups' => 'Tomato sauce and seafood',
				'image_url' => '/product-images/pizza-5.jpg',
				'slug' => 'frutti-di-mare-pizza',
				'selling_price' => 49,
				'selling_price_euro' => 44
			],[
				'title' => 'Quattro Formaggi',
				'add_ups' => 'Parmesan, artichokes, and oregano',
				'image_url' => '/product-images/pizza-6.jpg',
				'slug' => 'quattro-formaggi-pizza',
				'selling_price' => 21,
				'selling_price_euro' => 19
			],[
				'title' => 'Crudo',
				'add_ups' => 'Mozzarella and Parma ham',
				'image_url' => '/product-images/pizza-7.jpg',
				'slug' => 'crudo-pizza',
				'selling_price' => 35,
				'selling_price_euro' => 32
			],[
				'title' => 'Napoletana',
				'add_ups' => 'Mozzarella, oregano, anchovies',
				'image_url' => '/product-images/pizza-8.jpg',
				'slug' => 'napoletana-pizza',
				'selling_price' => 19,
				'selling_price_euro' => 17
			],[
				'title' => 'Cruncy Cops',
				'add_ups' => 'Parmesan, oregano and Parma ham',
				'image_url' => '/product-images/pizza-9.jpg',
				'slug' => 'cruncy-cops-pizza',
				'selling_price' => 12,
				'selling_price_euro' => 11
			]
        ]);
    }
}
