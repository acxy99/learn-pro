<?php

use Illuminate\Database\Seeder;

use App\Topic;
use App\Course;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        factory(Course::class, 2)->create();
        factory(Topic::class, 10)->create();
    }
}
