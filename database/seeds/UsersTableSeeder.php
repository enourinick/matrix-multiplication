<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::unguard();
        User::query()->create([
            'name' => 'Admin',
            'email' => 'admin@aboutyou.de',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ]);
        User::reguard();
    }
}
