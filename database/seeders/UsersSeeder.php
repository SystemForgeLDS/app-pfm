<?php

namespace Database\Seeders;

use App\Constants\UserRoles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'type' => UserRoles::PARTNER,
            'value_hour' => 100
        ]);

        $types = [UserRoles::PARTNER, UserRoles::CONSULTANT, UserRoles::FINANCIER, UserRoles::INTERN];
        foreach ($types as $type) {
            User::factory()->create([
                'type' => $type,
            ]);
        }

        User::factory(10)->create();
    }
}
