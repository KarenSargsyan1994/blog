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


//        factory(App\Tasks::class, 10)->create();
//        $taskIds = DB::table('tasks')->pluck('id')->toArray();
//
//
//        factory(App\User::class, 10)->create()->each(function($user) use($taskIds)
//        {
//            $user->projects()->saveMany(factory(App\Projects::class, 3)
//                ->create(['user_id' => $user->id])->each(function($projects) use($taskIds)
//                {
//                    $projects->tasks()->sync(array_random($taskIds, mt_rand(1, 5)));
//                }));
//        });
//        factory(App\User::class, 15)->create()->each(function ($user) {
//            $user->projects()->saveMany(factory(App\Projects::class, rand(5, 15))->make())->each(function ($project) {
//                $project->tasks()->saveMany(factory(App\Tasks::class, rand(5, 14))->make());
//            });
//
//        });

        factory(App\User::class, 10)->create()->each(function ($user) {
            $projects = factory(App\Projects::class, rand(4, 5))->make();
            $user->projects()->saveMany($projects);
            $task = factory(App\Tasks::class, rand(8, 15))->make();
            $user->tasks()->saveMany($task);

        });


//
//        });

        \App\User::first()->update([
            'email' => 'karen_sargsyan_1994@mail.ru'
        ]);

    }

}
