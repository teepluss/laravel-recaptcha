<?php namespace Teepluss\Recaptcha;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class RecaptchaServiceProvider extends ServiceProvider {

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
        $this->package('teepluss/recaptcha');

        // Auto create app alias with boot method.
        AliasLoader::getInstance()->alias('Recaptcha', 'Teepluss\Recaptcha\Facades\Recaptcha');

        $this->addValidator();
        $this->addFormMacro();
    }

    /**
     * Extend validator.
     *
     * @return void
     */
    protected function addValidator()
    {
        // Extend validation method.
        $this->app['validator']->extend('recaptcha', function($attribute, $value, $parameters)
        {
            $reCaptcha = app('recaptcha');

            return $reCaptcha->check($value);
        });
    }

    /**
     * Extend form macro.
     *
     * @return void
     */
    protected function addFormMacro()
    {
        // Register form macro.
        if (isset($this->app['form']))
        {
            $this->app['form']->macro('recaptcha', function()
            {
                $reCaptcha = app('recaptcha');

                return $reCaptcha->render();
            });
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['recaptcha'] = $this->app->share(function($app)
        {
            $config = $app['config']['recaptcha::config'];

            return new Recaptcha($config, $app['view'], $app['request']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('recaptcha');
    }

}
