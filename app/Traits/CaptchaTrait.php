<?php namespace App\Traits;
 
use Input;
use ReCaptcha\ReCaptcha;
 
trait CaptchaTrait {
 
    public function captchaCheck()
    {
 
        $response = Input::get('g-recaptcha-response');
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $secret   = config('services.g-recaptcha.secret');
 
        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteip);
        if ($resp->isSuccess()) {
            return true;
        } else {
            return false;
        }
 
    }
 
}