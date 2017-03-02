<?php

namespace Yaro\Mecha;

use Illuminate\Support\ServiceProvider as IlluminateProvider;
use Illuminate\Support\Facades\View;


class ServiceProvider extends IlluminateProvider
{

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('yaro.mecha.php'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../../../public' => public_path('packages/yaro/mecha'),
        ], 'public');

		include __DIR__.'/../../helpers.php';
		include __DIR__.'/../../routes.php';

		View::addNamespace('mecha', __DIR__.'/../../views/');
	} // end boot

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('yaro_mecha', function($app) {
            return new Mecha();
        });
	} // end register

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
