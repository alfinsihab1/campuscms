<?php

namespace Ajifatur\FaturCMS\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Ajifatur\FaturCMS\FaturCMSServiceProvider;

class UpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faturcms:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update FaturCMS package';

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
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if(file_exists(getcwd().'/composer.phar')){
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }

        return 'composer';
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // First info
        $this->info('Updating FaturCMS package');

        // Copy assets
        $this->info('Copying Assets');
        File::copyDirectory(package_path('publishable/assets'), public_path('assets'));

        // Copy templates
        $this->info('Copying Templates');
        File::copyDirectory(package_path('publishable/templates'), public_path('templates'));

        // Run main command
        $this->call('faturcms:main');

        // Last info
        $this->info('Successfully updating FaturCMS! Enjoy');
    }
}
