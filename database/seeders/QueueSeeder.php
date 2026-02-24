<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Queue;
use Illuminate\Database\Seeder;

class QueueSeeder extends Seeder
{
    public function run(): void
    {
        $business = Business::firstOrCreate(
            ['slug' => 'chamindu-salon'],
            ['name' => 'Chamindu Salon']
        );

        Queue::firstOrCreate(
            ['slug' => 'haircut'],
            [
                'business_id'      => $business->id,
                'name'             => 'Haircut',
                'current_position' => 0,
            ]
        );
    }
}
