## Laravel reCAPTCHA.

Are you a robot? Introducing “No CAPTCHA reCAPTCHA”

[![reCAPTCHA from Google](https://www.google.com/recaptcha/intro/images/hero-recaptcha-demo.gif)](https://www.google.com/recaptcha/intro/index.html)

### Installation

- [Recaptcha on Packagist](https://packagist.org/packages/teepluss/recaptcha)
- [Recaptcha on GitHub](https://github.com/teepluss/laravel-recaptcha)

To get the lastest version of Recaptcha simply require it in your `composer.json` file.

~~~
"teepluss/recaptcha": "dev-master"
~~~

You'll then need to run `composer install` to download it and have the autoloader updated.

Once reCAPTCHA is installed you need to register the service provider with the application. Open up `app/config/app.php` and find the `providers` key.

~~~
'providers' => array(
    'Teepluss\Recaptcha\RecaptchaServiceProvider'
)
~~~

Publish config using artisan CLI.

~~~
php artisan publish:config teepluss/recaptcha
~~~

Publish view using artisan CLI.

~~~php
php artisan view:publish teepluss/recaptcha
~~~

## Usage

The first you need to config key and secret that get from [Google](https://www.google.com/recaptcha/intro/index.html)

### Display captcha on view

~~~php
echo Recaptcha::render();

// or

echo Form::recaptcha();
~~~

### Verify captcha from the server

~~~php
$v = Validator::make(
    Input::all(),
    array(
        'g-recaptcha-response' => 'required|recaptcha'
    ),
    array(
        'g-recaptcha-response.recaptcha' => 'Please verify that you are not a robot.'
    )
);

if ($v->fails())
{
    var_dump($v->messages());
}
~~~

## Support or Contact

If you have some problem, Contact teepluss@gmail.com

[![Support via PayPal](https://rawgithub.com/chris---/Donation-Badges/master/paypal.jpeg)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9GEC8J7FAG6JA)
