<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): User
    {
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => Carbon::now()
        ]);

        return $testUser;
    }
}
