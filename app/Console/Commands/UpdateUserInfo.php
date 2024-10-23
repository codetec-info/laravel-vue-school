<?php

namespace App\Console\Commands;

use App\Models\User;
use Arr;
use Faker\Factory;
use Illuminate\Console\Command;

class UpdateUserInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update users\' firstname, lastname, and timezone with new random ones';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $faker = Factory::create();
        $timezones = ['CET', 'CST', 'GMT+1'];

        $users = User::all();

        $this->withProgressBar($users, function ($user) use ($faker, $timezones) {
            $user->first_name = $faker->firstName;
            $user->last_name = $faker->lastName;
            $user->timezone = Arr::random($timezones);
            $user->save();
        });

        $this->newLine();
        $this->info('User information updated successfully.');
    }
}
