<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Enums\Role;
use App\Models\Pet;
use App\Models\User;
use App\Models\Image;
use App\Models\Review;
use App\Models\Request;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Database\Factories\ImageFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Custom animals
        $animals = ['Joey', 'Marc', 'Stan', 'Peter'];
        $type = ['Hond', 'Slang', 'Kat', 'Vis'];

        // Create 4 dummy requests
        for ($i = 0; $i < 4; $i++){
            $pet = Pet::factory()->create([
                'name' => $animals[$i],
                'type' => $type[$i],
            ]);

            Image::factory()->create([
                'pet_id' => $pet->id,
                'path' => "/pets/" . $type[$i] . ".jpeg"
            ]);

            Request::factory()->create([
                'pet_id' => $pet->id,
                'owner_id' => $pet->owner_id
            ]);
        };

        // Create test owner
        $test_owner = User::factory()->create([
            'name' => 'Baasje test',
            'email' => 'owner@test.com',
            'password' => bcrypt('test123456'),
        ]);

        $test_pet = Pet::factory()->create([
            'owner_id' => $test_owner,
            'type' => 'Schildpad'
        ]);

        Image::factory()->create([
            'pet_id' => $test_pet->id,
            'path' => "/pets/Schildpad.jpeg"
        ]);

        $sit = User::factory()->create([
            'role' => 'Sitter',
        ]);

        Image::factory()->create([
            'user_id' => $sit->id,
            'path' => "/sitters/Sitter1_2.webp"
        ]);

       Request::factory()->create([
            'from' => fake()->dateTimeThisMonth('-20 days'),
            'till' => fake()->dateTimeThisMonth('-3 days'),
            'owner_id' => $test_owner->id,
            'pet_id' => $test_pet->id,
            'sitter_id' => $sit->id,
            'status' => 1,
        ]);


        // Create test sitter with some reviews
        $sitter = User::factory()->create([
            'role' => 'Sitter',
            'name' => 'Oppas test',
            'email' => 'sitter@test.com',
            'password' => bcrypt('test1234567'),
        ]);

        $request = Request::factory()->create([
            'from' => fake()->dateTimeThisMonth('-20 days'),
            'till' => Carbon::now(),
            'sitter_id' => $sitter->id,
            'status' => 1,
        ]);

        Review::factory()->create([
            'request_id' => $request->id,
        ]);

        // Create Admin user
        User::factory()->create([
            'name' => 'admin',
            'email' => 'test@admin.com',
            'password' => bcrypt('admin'),
            'role' => Role::Admin->value,
        ]);
    }
}
