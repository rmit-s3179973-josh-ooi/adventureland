<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Event;
use CategoryDatabaseSeeder as CategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(UsersTableSeeder::class);

    }
}

class UsersTableSeeder extends Seeder
{

	public function run()
	{
		User::create([
			'name' => 'Josh Ooi',
			'email' =>'josh.ronald.ooi@gmail.com',
			'password' => bcrypt('qweasd'),
			'email_verified_at' => now(),
			'remember_token' => str_random(10),
		]);

		factory(User::class, 10)->create()->each(function($u) {
			for($i=0;$i<5;$i++){
				$u->events()->save(factory(Event::class)->make(),['is_creator'=>true]);	
			}			
		});
	}
}