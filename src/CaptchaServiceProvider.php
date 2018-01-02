<?php

namespace Kabir\Captcha;

use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //include __DIR__.'/routes.php';
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('captcha', function ($app) {
            return new Captcha();
        });

        $this->app->alias('captcha', Captcha::class);

      /*$this->app->singleton('captcha', function ($app) {
        return Captcha::instance();
      });*/
    }

    /**
  	 * Get the services provided by the provider.
  	 *
  	 * @return array
  	 */
  	public function provides()
  	{
  		return array(
  			'captcha'
  		);
  	}
}
