<?php 
namespace App\Console\Commands;

use Illuminate\Console\Command;

class KeyGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate New Key for encryption';

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
     *
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        $path = base_path('.env');
        $key = \Illuminate\Support\Str::random(32);
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                'APP_KEY='.config('envKeys.app_key'), 'APP_KEY='.$key, file_get_contents($path)
            ));
        }

         $this->info('Key Generated Successfully.');

    }
}