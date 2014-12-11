<?php namespace Teepluss\Recaptcha;

class Recaptcha {

    /**
     * Endpoint to verify captcha.
     *
     * @var string
     */
    protected $endpoint = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * Construction.
     *
     * @param  array                   $config
     * @param \Illuminate\View\Factory $view
     * @param \Illuminate\Http\Request $request
     */
    public function __construct($config, $view, $request)
    {
        $this->config = $config;

        $this->view = $view;

        $this->request = $request;
    }

    /**
     * Render captcha to form.
     *
     * @return string HTML
     */
    public function render()
    {
        $key = $this->config['key'];
        $className = $this->config['className'];

        return $this->view->make('recaptcha::form', compact('key', 'className'));
    }

    /**
     * Verify captcha.
     *
     * @param  string  $value
     * @return boolean
     */
    public function check($value)
    {
        $secret = $this->config['secret'];

        $ip = $this->request->server('REMOTE_ADDR');

        $data = array(
            'secret'   => $secret,
            'response' => $value,
            'remoteip' => $ip
        );

        $response = $this->makeRequest($data);
        $response = json_decode($response, true);

        return is_array($response) and $response['success'] === true;
    }

    /**
     * Request from google.
     *
     * @param  array $data
     * @return mixed
     */
    protected function makeRequest($data)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->endpoint . '?' . http_build_query($data));
        //curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'post');
        //curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 15);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

}

