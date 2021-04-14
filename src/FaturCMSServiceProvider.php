<?php

namespace Ajifatur\FaturCMS;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Ajifatur\FaturCMS\Http\Middleware\AdminMiddleware;
use Ajifatur\FaturCMS\Http\Middleware\MemberMiddleware;
use Ajifatur\FaturCMS\Http\Middleware\GuestMiddleware;
use Maatwebsite\Excel\ExcelServiceProvider;

class FaturCMSServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any package services.
	 *
	 * @return void
	 */
	public function boot(Router $router)
	{
        // Register other packages
        $this->app->register(ExcelServiceProvider::class);

		// Add package's view.
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'faturcms');

        // Add middlewares
        $router->aliasMiddleware('faturcms.admin', AdminMiddleware::class);
        $router->aliasMiddleware('faturcms.member', MemberMiddleware::class);
        $router->aliasMiddleware('faturcms.guest', GuestMiddleware::class);
	}

    /**
     * Register the application services.
     */
    public function register()
    {
        // Load helpers.
        $this->loadHelpers();
        
        // Load install command.
        $this->commands(Commands\InstallCommand::class);

        if($this->app->runningInConsole()){
            // Register publishable resources.
            $this->registerPublishableResources();

            // Register console commands.
            $this->registerConsoleCommands();
        }
    }

    /**
     * Load helpers.
     * 
	 * @return void
     */
    protected function loadHelpers()
    {
        foreach(glob(__DIR__.'/Helpers/*.php') as $filename){
            require_once $filename;
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
            'config' => [
                "{$publishablePath}/config/faturcms.php" => config_path('faturcms.php'),
            ],
        ];

        foreach($publishable as $group => $paths){
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