<?php

namespace Database\Seeders;

use App\Models\Employees;
use Faker\Core\Number;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        for($i=0;$i<5;$i++) {
            DB::table('users')->insert(array(
                'user_id' => $i,
                'first_name' => Str::random(10),
                'last_name' => Str::random(10),
                'role' => 'user',
                'division' => 'web',
                'join_date' => date('Y-m-d'),
                'email' => Str::random(10) . '@gmail.com',
                'password' => bcrypt('1234'),
            ));
        }
//            for($i=0;$i<5;$i++) {
                DB::table('attendances')->insert(array(
                    'user_id' => 1,
                    'work_date' => date('Y-m-d'),

                ));
//        }
        //insert anual leave
        DB::table('annual_leaves')->insert(array(
            'user_id' => 3,
            'leave_date' => date('Y-m-d'),
            'reason' => 'something',
            'status' => 0


        ));

    }
}
