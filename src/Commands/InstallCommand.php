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

        // Seed
        $this->call('db:seed');
        
        // Run main command
        $this->call('faturcms:main');

        // Last info
        $this->info('Successfully installing FaturCMS! Enjoy');
    }
}
