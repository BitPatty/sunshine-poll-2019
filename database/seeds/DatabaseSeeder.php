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
        factory(\App\Models\User::class, 24)->create();

        $users = \App\Models\User::all();

        foreach ($users as $user) {
            factory(\App\Models\Vote::class)->create([
                'user_id' => $user->id,
                'comment' => '(Seeded Vote)',
            ]);
        }

        $votes = \App\Models\Vote::all();
        foreach ($votes as $vote) {
            \App\Models\VoteHistory::addEntry($vote);
            \App\Models\VerificationHistory::addEntry($vote, \App\Models\User::getServiceAccount());
        }
    }
}
