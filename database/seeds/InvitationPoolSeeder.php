<?php

use Illuminate\Database\Seeder;

class InvitationPoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\InvitationPool::class)->create(['survey_id' => 3])
            ->each(function ($pool) {
                factory(App\InvitationEmails::class, 3)->create(['invitation_pool_id' => $pool->id]);
            });
    }
}
