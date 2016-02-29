<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\BeTagModel;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        $faker = Faker\Factory::create();
        for ($i=0; $i < 10; $i++) { 
            BeTagModel::create([
                'name' => $faker->sentence,
                'name_alias' => implode('',$faker->sentences(4)),
                'status' => $faker->randomDigit(),
                'created_by' => $faker->unixTime(),
                'updated_by' => $faker->unixTime(),
                'created_at' => $faker->unixTime(),
                'updated_at' => $faker->unixTime(),
            ]);
        }

        Model::reguard();
    }
}
