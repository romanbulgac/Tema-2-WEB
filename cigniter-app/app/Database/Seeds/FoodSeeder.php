<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class FoodSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $this->db->table('food')->insert($this->generateRecords());
        }
    }
    private function generateRecords()
    {
        $faker = Factory::create();
        return ['title'=>$faker->name, 'description'=>$faker->sentence, 'price'=>$faker->numberBetween($min = 5, $max = 100)];
    }
}
