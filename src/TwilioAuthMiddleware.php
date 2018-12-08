<?php

namespace Princeton255\TwilioMiddleware;

use Closure;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Http\Request;
use Twilio\Security\RequestValidator;

class TwilioAuthMiddleware extends AuthenticateWithBasicAuth
{
    public function handle($request, Closure $next, $guard = null, $field = null)
    {
        if (app()->environment('production') && ! $this->validateSignature($request)) {

            $msg = 'Invalid signature for request!. Please check if you are sending a valid X-Twilio-Signature header.';

            if (config('app.debug')) {
                $msg .= ' If you are the owner of this API, check if you have set the services.twilio.secret config key correctly!';
            }

            logger($msg);

            return response("<Response><error>$msg</error></Response>", 403, [
                'Content-Type' => 'application/xml',
            ]);
        }

        return $next($request);
    }

    /**
     * Refer to url below for documentation.
     * https://www.twilio.com/docs/usage/security.
     * @param Request $request
     * @return bool
     */
    public function validateSignature($request)
    {
        // Your auth token from twilio.com/user/account
        $token = config('services.twilio.secret');

        // The X-Twilio-Signature header - in PHP this should be
        // $_SERVER["HTTP_X_TWILIO_SIGNATURE"];
        $signature = $request->header('X-Twilio-Signature');

        // Initialize the validator
        $validator = new RequestValidator($token);

        // The Twilio request URL. You may be able to retrieve this from
        // $_SERVER['SCRIPT_URI']
        $url = $request->fullUrl();

        // The post variables in the Twilio request. You may be able to use
        // $postVars = $_POST
        $postVars = $request->post();

        if ($validator->validate($signature, $url, $postVars)) {
            return true;
        } else {
            return false;
        }
    }
}
