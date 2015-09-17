<?php namespace Watson\Taggly;

use Illuminate\Support\ServiceProvider;

class TagglyServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('tag', 'Watson\Taggly\Taggly');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['tag'];
	}

	/**
	 * Perform post-registration booting of services.
	 *
	 * @return void
	 */
	public function boot()
	{
	    $this->publishes([
	        __DIR__.'/../config/taggly.php' => config_path('taggly.php'),
	    ]);
	}

}
