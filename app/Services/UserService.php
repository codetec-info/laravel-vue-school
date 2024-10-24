<?php

namespace App\Services;

use App\Models\User;
use Cache;
use Log;

class UserService
{
    public const BATCH_SIZE = 3;

    protected mixed $batch = [];

    public function __construct()
    {
        $this->batch = Cache::get('api_batch', []);
    }

    public function addToBatch(User $user, $changes): void
    {
        $userObj = [
            'email' => $user->email
        ];

        $userObj = array_merge($userObj, $changes);

        $this->batch[] = $userObj;

        Cache::put('api_batch', $this->batch, now()->addMinutes(10));
    }

    public function sendBatch(): void
    {
        if (count($this->batch) > 0) {
            $batchToSend = array_slice($this->batch, 0, self::BATCH_SIZE);

//            Http::post('https://api.example.com/batch', [
//                'batches' => [
//                    'subscribers' => $batchToSend,
//                ],
//            ]);

            Log::debug('Batch sent', $batchToSend);

            $this->batch = array_slice($this->batch, self::BATCH_SIZE);

            Cache::put('api_batch', $this->batch, now()->addMinutes(10));
        }
    }
}
