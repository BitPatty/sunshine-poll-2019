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
        factory(\App\Models\User::class, 100)->create();

        $users = \App\Models\User::all();

        foreach ($users as $user) {
            factory(\App\Models\Vote::class)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
