<?php

namespace Ajifatur\FaturCMS\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
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
     * Execute the console command.
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {
        // First info
        $this->info('Updating FaturCMS package');

        // Copy assets
        $this->info('Copying Assets');
        File::copyDirectory(package_path('publishable/assets'), public_path('assets'));

        // Copy templates
        $this->info('Copying Templates');
        File::copyDirectory(package_path('publishable/templates'), public_path('templates'));

        // Copy seeds
        $this->info('Copying Seeds');
        File::copyDirectory(package_path('publishable/seeds'), database_path('seeders'));
        $seed_files = generate_file(package_path('publishable/seeds'));
        if(count($seed_files)>0){
            foreach($seed_files as $seed_file){
                file_replace_contents(package_path('publishable/seeds/'.$seed_file), database_path('seeders/'.$seed_file));
            }
        }

        // Run main command
        $this->call('faturcms:main');

        // Composer dump autoload
        $composer = new Composer($filesystem);
        $composer->dumpAutoloads();

        // Migrate
        $this->call('migrate');

        // Seed
        $this->call('db:seed');

        // Last info
        $this->info('Successfully updating FaturCMS! Enjoy');
    }
}
