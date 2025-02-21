<?php

declare(strict_types=1);
/**
 * Plugin Google reCaptcha
 * https://github.com/torvista/Zen_Cart-Google_reCAPTCHA
 * @license https://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @updated  $Id: torvista 2024 11 04
 */

/* https://developers.google.com/recaptcha/docs/verify
Last updated 2024-10-14 UTC.
    missing-input-secret	The secret parameter is missing.
    invalid-input-secret	The secret parameter is invalid or malformed.
    missing-input-response	The response parameter is missing.
    invalid-input-response	The response parameter is invalid or malformed.
    bad-request	            The request is invalid or malformed.
    timeout-or-duplicate	The response is no longer valid: either is too old or has been used previously
 */
$define = [
     'RECAPTCHA_UNDEFINED_SITEKEY' => '** reCaptcha: sitekey undefined  **',
     'RECAPTCHA_MISSING_INPUT_SECRET' => 'reCaptcha: missing secret key',
     'RECAPTCHA_INVALID_INPUT_SECRET' => 'reCaptcha: invalid secret key',
     'RECAPTCHA_MISSING_INPUT_RESPONSE' => 'Please click the "I\'m not a robot" reCaptcha box to prove you are human!',
     'RECAPTCHA_INVALID_INPUT_RESPONSE' => 'Sorry, please verify again that you are not a robot',
     'RECAPTCHA_BAD_REQUEST' => 'reCaptcha: the request is invalid or malformed',
     'RECAPTCHA_TIMEOUT_OR_DUPLICATE' => 'reCaptcha: timeout or duplicate request',
     'RECAPTCHA_PRIVATE_KEY_NOT_MATCHED' => 'reCaptcha: the private key does not match this domain',
];

return $define;
