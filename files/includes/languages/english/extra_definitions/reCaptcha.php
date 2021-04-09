<?php //Plugin Google reCaptcha
/**
 * @package languageDefines
 * @copyright Copyright 2003-2010 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
/* https://developers.google.com/recaptcha/docs/verify
    invalid-input-secret	The secret parameter is invalid or malformed.
    missing-input-response	The response parameter is missing.
    invalid-input-response	The response parameter is invalid or malformed.
    bad-request	The request is invalid or malformed.
    timeout-or-duplicate	The response is no longer valid: either is too old or has been used previously
 */
define('RECAPTCHA_MISSING_INPUT_SECRET' , 'missing-input-secret');
define('RECAPTCHA_INVALID_INPUT_SECRET' , 'invalid-input-secret');
define('RECAPTCHA_MISSING_INPUT_RESPONSE' , 'Please click the "I\'m not a robot" reCaptcha box to prove you are human!');
define('RECAPTCHA_INVALID_INPUT_RESPONSE' , 'Sorry, please verify again that you are not a robot');
define('RECAPTCHA_BAD_REQUEST' , 'The request is invalid or malformed');
define('RECAPTCHA_TIMEOUT_OR_DUPLICATE' , 'timeout-or-duplicate');
