<?php

namespace Ajifatur\FaturCMS\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
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
        $this->info('Installing FaturCMS package');

        // Publish resources
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'assets']);
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'templates']);
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'config']);

        // Find composer
        $composer = $this->findComposer();

        // Dump autoload
        $process = new Process([$composer.' dump-autoload']);
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setWorkingDirectory(base_path())->run();

        $this->info('Successfully installed FaturCMS! Enjoy');
    }
}
