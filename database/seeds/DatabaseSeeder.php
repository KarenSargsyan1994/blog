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

        factory(App\User::class, 10)->create()->each(function ($user) {
            $projects = factory(App\Projects::class, rand(4, 10))->make();
            $user->projects()->saveMany($projects);
            $task = factory(App\Tasks::class, rand(8, 15))->make();
            $user->tasks()->saveMany($task);

        });


        \App\User::first()->update([
            'email' => 'karen_sargsyan_1994@mail.ru'
        ]);

    }

}
