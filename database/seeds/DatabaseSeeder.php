<?php

use Illuminate\Database\Seeder;

use App\Order;

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
        factory(Order::class, 5)->create();
    }
}
