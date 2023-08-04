<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class DiscoverNgrokUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ngrok:discover';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Discovers the public URL for active ngrok tunnel.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = (new Client(['http_errors' => false]))
            ->get('http://ngrok:4040/api/tunnels');
        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $json = json_decode((string) $response->getBody(), true);

        $ngrokUrl = $json['tunnels'][0]['public_url'];
        $this->line($ngrokUrl);
    }
}
