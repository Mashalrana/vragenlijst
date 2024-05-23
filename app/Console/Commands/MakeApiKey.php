<?php

namespace App\Console\Commands;

use App\Models\ApiKey;
use Illuminate\Console\Command;

class MakeApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apikey:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an API key for Mailcoach';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiKey = ApiKey::create();

        $this->info("API key created: {$apiKey->id}");
    }
}
