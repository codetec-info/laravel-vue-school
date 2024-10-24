<?php

use App\Models\User;
use App\Services\UserService;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Cache::forget('api_batch');
});

uses(RefreshDatabase::class);

it('sends a batch of up to 1000 records', function () {

    $faker = Factory::create();
    $timezones = ['CET', 'CST', 'GMT+1'];

    // Create 1001 users and update them to trigger the observer
    User::factory()->count(UserService::BATCH_SIZE + 1)->create()->each(function ($user) use ($timezones, $faker) {
        $user->update([
            'timezone' => Arr::random($timezones),
            'first_name' =>  $faker->firstName,
            'last_name' =>  $faker->lastName,
        ]);
    });

    // Call the sendBatch method
    app(UserService::class)->sendBatch();

    // Assert that the remaining 1 user is still in the batch
    $remainingBatch = Cache::get('api_batch');

    expect(count($remainingBatch))->toBe(1);
});
