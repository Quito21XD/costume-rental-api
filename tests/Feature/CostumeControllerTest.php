<?php

use App\Models\Category;
use App\Models\Piece;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

it('handles multiple scenarios for costume creation', function () {
    Storage::fake('costumes');
    $user = User::factory()->create();
    $this->actingAs($user);

    $categories = Category::factory()->count(2)->create();
    $pieces = Piece::factory()->count(2)->create();

    $scenarios = [
        'valid_data' => [
            'data' => [
                'name' => 'Valid Costume',
                'description' => 'A valid costume description',
                'gender' => 'unisex',
                'rental_price' => 150.00,
                'categories' => $categories->pluck('id')->toArray(),
                'pieces' => $pieces->map(fn ($piece) => ['id' => $piece->id, 'stock' => 10])->toArray(),
                'image' => UploadedFile::fake()->image('costume.jpg'),
            ],
            'expected_status' => 201,
            'validation_errors' => [],
        ],
        'invalid_gender' => [
            'data' => [
                'name' => 'Invalid Costume',
                'description' => 'Invalid data',
                'gender' => 'unknown', // Género no permitido
                'rental_price' => 100.00,
                'categories' => $categories->pluck('id')->toArray(),
                'pieces' => $pieces->map(fn ($piece) => ['id' => $piece->id, 'stock' => 10])->toArray(),
                'image' => UploadedFile::fake()->image('costume.jpg'),
            ],
            'expected_status' => 422,
            'validation_errors' => ['gender'],
        ],
        'invalid_image' => [
            'data' => [
                'name' => 'Invalid Image',
                'description' => 'Testing invalid image upload',
                'gender' => 'unisex',
                'rental_price' => 100.00,
                'categories' => $categories->pluck('id')->toArray(),
                'pieces' => $pieces->map(fn ($piece) => ['id' => $piece->id, 'stock' => 10])->toArray(),
                'image' => UploadedFile::fake()->create('not-an-image.txt', 100, 'text/plain'),
            ],
            'expected_status' => 422,
            'validation_errors' => ['image'],
        ],
    ];

    foreach ($scenarios as $scenario => $config) {
        $response = $this->postJson(route('costumes.store'), $config['data']);

        $response->assertStatus($config['expected_status']);

        if (! empty($config['validation_errors'])) {
            $response->assertJsonValidationErrors($config['validation_errors']);
        } else {
            $this->assertDatabaseHas('costumes', ['name' => $config['data']['name']]);
        }
    }
});
