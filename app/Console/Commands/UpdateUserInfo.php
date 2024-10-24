<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\UserService;
use Arr;
use Faker\Factory;
use Illuminate\Console\Command;

class UpdateUserInfo extends Command
{
    protected $signature = 'user:update-info';

    protected $description = 'Update users\' firstname, lastname, and timezone with new random ones';

    public function handle(): void
    {
        $faker = Factory::create();

        $users = User::inRandomOrder()
            ->take(UserService::BATCH_SIZE + 1)
            ->get();

        $this->withProgressBar($users, function ($user) use ($faker) {
            $timezones = ['CET', 'CST', 'GMT+1'];
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->timezone = Arr::random($timezones);
            $user->save();
        });

        $this->newLine();
        $this->info('User information updated successfully.');
    }
}
