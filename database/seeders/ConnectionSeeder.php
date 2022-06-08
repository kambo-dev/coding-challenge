<?php

namespace Database\Seeders;

use App\Enums\RequestStatuses;
use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // test user
        $user = User::factory()
            ->create([
                'name' => 'Test User',
                'email' => 'user@test.com'
            ]);

        Request::factory()
            ->count(50)
            ->state(new Sequence(
                ['status' => RequestStatuses::SENT],
                ['status' => RequestStatuses::ACCEPTED],
                ['status' => RequestStatuses::REFUSED],
            ))
            ->create([
                'initiator_id' => $user->id,
            ]);

        Request::factory()
            ->count(50)
            ->state(new Sequence(
                ['status' => RequestStatuses::SENT],
                ['status' => RequestStatuses::ACCEPTED],
                ['status' => RequestStatuses::REFUSED],
            ))
            ->create([
                'target_id' => $user->id,
            ]);

        $connected = Request::query()
            ->with(['target'])
            ->where('initiator_id', $user->id)
            ->where('status', RequestStatuses::ACCEPTED)
            ->get()
            ->pluck('target.id');

        /** @var User $user */
        $user->connections()->attach($connected, [
            'connected_at' => now()
        ]);
    }
}
