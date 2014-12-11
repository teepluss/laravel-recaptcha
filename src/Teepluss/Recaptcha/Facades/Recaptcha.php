<?php namespace Teepluss\Recaptcha\Facades;

use Illuminate\Support\Facades\Facade;

class Recaptcha extends Facade {

    /**
     * Get the registered name of the component.
     *
     * If you got a problem about this facade
     * you may checking on sensitive case.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'recaptcha'; }

}
