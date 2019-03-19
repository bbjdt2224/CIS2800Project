<?php

use Illuminate\Database\Seeder;
use App\User;

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

        $names = array('Justin True', 'Daniel Desnoyer', 'Matthew Scutz', 'Richard Schafer', 'John Smith', 'Jane Doe', 'Benjamin Dover', 'Stuart Pidasso', 'Hugh Jerection', 'Dixie Normous');
        $emails = array('justin@wmich.edu', 'daniel@wmich.edu', 'matthew@wmich.edu', 'richard@wmich.edu', 'john@wmich.edu', 'jane@wmich.edu', 'ben@wmich.edu', 'stu@wmich.edu', 'hugh@wmich.edu', 'dixie@wmich.edu');

        factory(App\Shift::class, 100)->create();
        factory(App\Header::class, 30)->create();


        for($i = 0; $i < 5; $i++) {
            $random = rand(0, 9);
            $name = $names[$random];
            $email = $emails[$random];
            $orgId = factory(App\Organization::class)->create()->id;
            User::insert([
                'name' => $name,
                'email' => $email,
                'email_verified_at' => now(),
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'role' => 'admin',
                'organizationId' => $orgId,
                'remember_token' => str_random(10),
            ]);
        }

        User::insert([
            'name' => 'admin',
            'email' => 'admin@wmich.edu',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'role' => 'superadmin',
            'organizationId' => '0',
            'remember_token' => str_random(10),
        ]);
    }
}
