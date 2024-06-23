<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class EventSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $this->db->table('events')->insert($this->generateRecords());
        }
    }
    private function generateRecords()
    {
        $faker = Factory::create();
        return ['title'=>$faker->name, 'description'=>$faker->sentence, 'date'=>$faker->date];
    }
}
