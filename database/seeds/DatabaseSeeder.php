<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        factory(App\Shift::class, 100)->create();
        factory(App\Organization::class, 5)->create();
        factory(App\Header::class, 30)->create();
    }
}
