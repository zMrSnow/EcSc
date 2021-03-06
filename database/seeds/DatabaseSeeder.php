<?php

use App\Image;
use App\Product;
use App\Size;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(Product::class, 10)->create();
        factory(Image::class, 25)->create();
        //factory(Size::class, 25)->create();
    }
}
