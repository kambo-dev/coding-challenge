<?php

namespace Database\Seeders;

use App\Enums\RequestStatuses;
use App\Models\Request;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Request::factory()
            ->count(200)
            ->state(new Sequence(
                ['status' => RequestStatuses::SENT],
                ['status' => RequestStatuses::ACCEPTED],
                ['status' => RequestStatuses::REFUSED],
            ))
            ->create();
    }
}
