<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Exception;

class TestMongoConnection extends Command
{
    protected $signature = 'mongo:test';
    protected $description = 'Test MongoDB Connection';

    public function handle()
    {
        try {
            $result = DB::connection('mongodb')->collection('ticket')->skip(1)->take(1)->first();
            $this->info('MongoDB connection successful!');
            $this->info('Sample document: ' . json_encode($result));
        } catch (Exception $e) {
            $this->error('MongoDB connection failed: ' . $e->getMessage());
        }
    }
}
