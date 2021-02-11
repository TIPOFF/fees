<?php

namespace Database\Seeders\Production;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FeesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fees')->delete();

        DB::table('fees')->insert([
            0 => [
                'id' => 1,
                'slug' => 'zero',
                'name' => 'Zero',
                'title' => 'No Processing Fee',
                'amount' => 0,
                'percent' => '0.00',
                'applies_to' => 'order',
                'creator_id' => 1,
                'created_at' => '2020-05-08 12:36:26',
                'updated_at' => '2020-05-08 12:36:26',
            ],
            1 => [
                'id' => 2,
                'slug' => 'standard-participant-fee',
                'name' => 'Standard $1.80 per Participant',
                'title' => '$1.80 per Participant',
                'amount' => 180,
                'percent' => '0.00',
                'applies_to' => 'participant',
                'creator_id' => 1,
                'created_at' => '2020-05-09 15:12:00',
                'updated_at' => '2020-05-09 15:12:00',
            ],
        ]);
    }
}
