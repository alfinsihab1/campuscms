<?php

namespace Ajifatur\FaturCMS\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Ajifatur\FaturCMS\FaturCMSServiceProvider;

class MainCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'faturcms:main';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

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
        // Publish or update config/faturcms.php
        if(!File::exists(config_path('faturcms.php')))
            $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'config']);
        else{
            $this->info('Updating FaturCMS configuration');
            file_replace_contents(package_path('publishable/config/faturcms.php'), config_path('faturcms.php'));
        }

        // Publish or update app/Exceptions/Handler.php
        if(!File::exists(app_path('Exceptions/Handler.php')))
            $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'exception']);
        else{
            $this->info('Updating Exceptions Handler');
            file_replace_contents(package_path('publishable/exceptions/Handler.php'), app_path('Exceptions/Handler.php'));
        }

        // Publish or update app/User.php
        if(!File::exists(app_path('User.php')))
            $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'userModel']);
        else{
            $this->info('Updating Model User');
            file_replace_contents(package_path('publishable/models/User.php'), app_path('User.php'));
        }

        // Update web routes
        $this->info('Updating Web routes');
        file_replace_contents(
            '',
            base_path('routes/web.php'),
            '\Ajifatur\FaturCMS\FaturCMS::routes();',
            "\n".
            "// Letakkan fungsi ini pada route paling atas".
            "\n".
            "\Ajifatur\FaturCMS\FaturCMS::routes();".
            "\n"
        );

        // Update API routes
        $this->info('Updating API routes');
        file_replace_contents(
            '',
            base_path('routes/api.php'),
            '\Ajifatur\FaturCMS\FaturCMS::APIroutes();',
            "\n".
            "\n".
            "\Ajifatur\FaturCMS\FaturCMS::APIroutes();".
            "\n"
        );

        // Update config/app.php
        $this->info('Updating Application configuration');
        file_replace_contents(
            '',
            config_path('app.php'),
            "'timezone' => 'Asia/Jakarta'",
            "'timezone' => 'UTC'",
            true
        );

        // Update config/database.php
        $this->info('Updating Database configuration');
        file_replace_contents(
            '',
            config_path('database.php'),
            "'strict' => false",
            "'strict' => true",
            true
        );

        // Create folder storage/fonts
        if(!File::exists(storage_path('fonts'))) File::makeDirectory(storage_path('fonts'));
    }
}
