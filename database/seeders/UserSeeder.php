<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->nama = "Supervisor";
        $user->email = "spv@email.com";
        $user->npp = "11111";
        $user->password = Hash::make('password');
        $user->save();

        $user2 = new User;
        $user2->nama = "Ananda Bayu";
        $user2->email = "bayu@email.com";
        $user2->npp = "12345";
        $user2->npp_supervisor = "11111";
        $user2->password = Hash::make('password');
        $user2->save();
    }
}
