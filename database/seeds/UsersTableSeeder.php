<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'cid'        => 1275302,
                'first_name' => 'Blake',
                'last_name'  => 'Nahin',
                'email'      => 'blake@zseartcc.org',
                'password'   => Hash::make('secret'),
                'isAdmin'    => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
