<?php

namespace Ajifatur\FaturCMS\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Ajifatur\FaturCMS\FaturCMSServiceProvider;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faturcms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install FaturCMS package';

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
     * @return void
     */
    public function handle()
    {
        // First info
        $this->info('Installing FaturCMS package');

        // Publish assets and templates
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'assets']);
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'templates']);

        // Publish views
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'viewAuth']);
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'viewPDF']);

        // Publish seeds
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'seeds']);
        $seed_files = generate_file(package_path('publishable/seeds'));
        if(count($seed_files)>0){
            foreach($seed_files as $seed_file){
                file_replace_contents(package_path('publishable/seeds/'.$seed_file), database_path('seeds/'.$seed_file));
            }
        }

        // Run main command
        $this->call('faturcms:main');

        // Find composer and dump autoload
        $this->info('Dumping the autoloaded files and reloading all new files');
        $process = new Process([setting('site.server.php'), setting('site.server.composer'), 'dump-autoload'], base_path());
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setWorkingDirectory(base_path())->run();

        // Seed
        $this->call('db:seed');

        // Last info
        $this->info('Successfully installing FaturCMS! Enjoy');
    }
}
