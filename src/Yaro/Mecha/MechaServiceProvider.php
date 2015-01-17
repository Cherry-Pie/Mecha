<?php 

namespace Yaro\Mecha;

use Illuminate\Support\ServiceProvider;


class MechaServiceProvider extends ServiceProvider {

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
		$this->package('yaro/mecha');

		include __DIR__.'/../../routes.php';

		\View::addNamespace('mecha', __DIR__.'/../../views/');
	} // end boot

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['yaro_mecha'] = $this->app->share(function($app) {
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
