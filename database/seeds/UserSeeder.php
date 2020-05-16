<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        $user = new User();
        $user->name = 'Test';
        $user->email = 'test@mail.com';
        $user->email_verified_at = now();
        $user->password = bcrypt('abcd1234');
        $user->remember_token = Str::random(10);
        $user->full_address = 'Address';
        $user->cellphone_number = '0123456789';
        $user->save();
        Schema::enableForeignKeyConstraints();
    }
}
