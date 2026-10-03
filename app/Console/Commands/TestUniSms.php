<?php

namespace App\Console\Commands;

use App\Services\UniSmsService;
use Illuminate\Console\Command;
use Throwable;

class TestUniSms extends Command
{
    protected $signature = 'unisms:test {mobile}';

    protected $description = 'Send one test SMS through UniSMS';

    public function handle(UniSmsService $uniSmsService): int
    {
        $mobile = $this->argument('mobile');

        $this->info("Sending test SMS to {$mobile}...");

        try {
            $result = $uniSmsService->send(
                $mobile,
                'Hello from UniSMS!'
            );

            $this->info('SMS request completed successfully.');

            $this->line(
                json_encode($result, JSON_PRETTY_PRINT)
            );

            return self::SUCCESS;

        } catch (Throwable $e) {

            $this->error('SMS sending failed.');
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}