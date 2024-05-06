<?php

namespace Database\Seeders;

use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::factory()->create(['name' => 'user']);
        Role::factory()->create(['name' => 'admin']);
        Role::factory()->create(['name' => 'driver']);

        // Create users and assign them random roles
        for ($i = 0; $i < 10; $i++) {

            $user = User::factory()->create([
                'name' => 'Test User ' . $i,
                'email' => 'test' . $i . '@example.com',
            ]);
            $randomRole = Role::inRandomOrder()->first();
            $user->roles()->attach($randomRole);
        }
    }
}
