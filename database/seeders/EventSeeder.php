<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventBatch;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $event = Event::create([
            'name' => 'Yolo Fest 2023',
            'code' => 'YLF23',
            'start_date' => today(),
            'end_date' => today(),
            'description' => NULL,
            'image' => NULL,
            'contact_persons' => json_encode([
                [
                    'name' => 'Contact Person 01',
                    'phone_number' => '081234234234'
                ],
                [
                    'name' => 'Contact Person 02',
                    'phone_number' => '081345345345'
                ],
            ]),
            'status' => 'Aktif'
        ]);

        $eventBatch = EventBatch::create([
            'event_id' => $event->id,
            'name' => 'Early Bird',
            'description' => NULL,
            'start_date' => today()->subDays(7),
            'end_date' => today(),
            'price' => 100000,
            'max_ticket' => 1000,
            'status' => 'Aktif'
        ]);
    }
}
