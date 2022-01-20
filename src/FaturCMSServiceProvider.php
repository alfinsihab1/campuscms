<?php

namespace Ajifatur\FaturCMS;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Ajifatur\FaturCMS\Http\Middleware\AdminMiddleware;
use Ajifatur\FaturCMS\Http\Middleware\MemberMiddleware;
use Ajifatur\FaturCMS\Http\Middleware\GuestMiddleware;

class FaturCMSServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any package services.
	 *
	 * @return void
	 */
	public function boot(Router $router)
	{
		// Add package's view
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'faturcms');

        // Add package's migration
        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        // Add middlewares
        $router->aliasMiddleware('faturcms.admin', AdminMiddleware::class);
        $router->aliasMiddleware('faturcms.member', MemberMiddleware::class);
        $router->aliasMiddleware('faturcms.guest', GuestMiddleware::class);
		
		// Use Bootstrap on paginator
		Paginator::useBootstrap();
	}

    /**
     * Register the application services.
     */
    public function register()
    {
        // Load helpers
        $this->loadHelpers();
        
        // Load commands
        $this->commands(Commands\MainCommand::class);
        $this->commands(Commands\InstallCommand::class);
        $this->commands(Commands\UpdateCommand::class);

        if($this->app->runningInConsole()){
            // Register publishable resources
            $this->registerPublishableResources();

            // Register view resources
            $this->registerViewResources();

            // Register console commands
            $this->registerConsoleCommands();
        }

        // Register schedule
        $this->app->singleton('ajifatur.faturcms.console.kernel', function($app) {
            $dispatcher = $app->make(\Illuminate\Contracts\Events\Dispatcher::class);
            return new \Ajifatur\FaturCMS\Console\Kernel($app, $dispatcher);
        });
        $this->app->make('ajifatur.faturcms.console.kernel');
    }

    /**
     * Load helpers.
     * 
	 * @return void
     */
    protected function loadHelpers()
    {
        // Load helpers from FaturCMS
        foreach(glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once $filename;
        }

        // Load helpers from FaturHelper
        if(File::exists(base_path('vendor/campusdatamedia/faturhelper/src'))){
            foreach(glob(base_path('vendor/campusdatamedia/faturhelper/src').'/Helpers/*.php') as $filename){
                require_once $filename;
            }
        }
    }

    /**
     * Register the publishable files.
     * 
	 * @return void
     */
    private function registerPublishableResources()
    {
        $publishablePath = dirname(__DIR__).'/publishable';

        $publishable = [
            'assets' => [
                "{$publishablePath}/assets" => public_path('assets'),
            ],
            'templates' => [
                "{$publishablePath}/templates" => public_path('templates'),
            ],
            'seeds' => [
                "{$publishablePath}/seeds" => database_path('seeders'),
            ],
            'config' => [
                "{$publishablePath}/config/faturcms.php" => config_path('faturcms.php'),
            ],
            // 'exception' => [
            //     "{$publishablePath}/exceptions/Handler.php" => app_path('Exceptions/Handler.php'),
            // ],
            'userModel' => [
                "{$publishablePath}/models/User.php" => app_path('Models/User.php'),
            ],
        ];

        foreach($publishable as $group => $paths){
            $this->publishes($paths, $group);
        }
    }

    /**
     * Register the view files.
     * 
	 * @return void
     */
    private function registerViewResources()
    {
        $viewPath = dirname(__DIR__).'/resources/views';

        $view = [
            'viewAuth' => [
                "{$viewPath}/auth" => resource_path('views/auth'),
            ],
            'viewPDF' => [
                "{$viewPath}/pdf" => resource_path('views/pdf'),
            ],
        ];

        foreach($view as $group => $paths){
            $this->publishes($paths, $group);
        }
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        // $this->commands(Commands\InstallCommand::class);
    }
}
