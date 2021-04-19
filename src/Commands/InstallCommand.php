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

        // Publish assets and templates
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'assets']);
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'templates']);

        // Remove config file if exist and publish it
        if(File::exists(config_path('faturcms.php'))) File::delete(config_path('faturcms.php'));
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'config']);

        // Remove exception Handler if exist and publish it
        if(File::exists(app_path('Exceptions/Handler.php'))) File::delete(app_path('Exceptions/Handler.php'));
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'exception']);

        // Remove model User if exist and publish it
        if(File::exists(app_path('User.php'))) File::delete(app_path('User.php'));
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'userModel']);

        // Publish views
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'viewAuth']);
        $this->call('vendor:publish', ['--provider' => FaturCMSServiceProvider::class, '--tag' => 'viewPDF']);

        // Find composer
        $composer = $this->findComposer();

        // Dump autoload
        $process = new Process([$composer.' dump-autoload']);
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time
        $process->setWorkingDirectory(base_path())->run();

        // Add web routes
        $routes_contents = File::get(base_path('routes/web.php'));
        if(strpos($routes_contents, '\Ajifatur\FaturCMS\FaturCMS::routes();') === false){
            $this->info('Adding FaturCMS web routes to routes/web.php');
            File::append(
                base_path('routes/web.php'),
                "\n".
                "//Letakkan fungsi ini pada route paling atas".
                "\n".
                "\Ajifatur\FaturCMS\FaturCMS::routes();".
                "\n"
            );
        }

        // Add API routes
        $routes_contents = File::get(base_path('routes/api.php'));
        if(strpos($routes_contents, '\Ajifatur\FaturCMS\FaturCMS::APIroutes();') === false){
            $this->info('Adding FaturCMS API routes to routes/api.php');
            File::append(
                base_path('routes/api.php'),
                "\n\n\Ajifatur\FaturCMS\FaturCMS::APIroutes();\n"
            );
        }

        // Change app config
        $app_config_contents = File::get(config_path('app.php'));
        if(strpos($app_config_contents, "'timezone' => 'Asia/Jakarta'") === false){
            $this->info('Change app configuration in config/app.php');
            str_replace("'timezone' => 'UTC'", "'timezone' => 'Asia/Jakarta'", $app_config_contents);
            File::put(config_path('app.php'), $app_config_contents);
        }

        // Change database config
        $db_config_contents = File::get(config_path('database.php'));
        if(strpos($db_config_contents, "'strict' => false") === false){
            $this->info('Change database configuration in config/database.php');
            str_replace("'strict' => true", "'strict' => false", $db_config_contents);
            File::put(config_path('database.php'), $db_config_contents);
        }        

        $this->info('Successfully installed FaturCMS! Enjoy');
    }
}
