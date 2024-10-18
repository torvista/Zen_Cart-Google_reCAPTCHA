<?php

declare(strict_types=1);
/**
 * Plugin Google reCaptcha
 * https://github.com/torvista/Zen_Cart-Google_reCAPTCHA
 * @license https://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: torvista 05 September 2024
 */

//ENTER YOUR SITE DETAILS HERE
$reCaptchaKeys[] = [
    'domain' => 'www.yourdomain.whatever',
    'sitekey' => 'ENTER_YOUR_SITE_KEY_HERE',
    'privatekey' => 'ENTER_YOUR_PRIVATE_KEY_HERE'
];

//You may add more sites and keys to the array of domain/sitekey/privatekey, e.g. if you want to use the same code on a local and production server: each one needs their own keys from Google. Add them into the next line and uncomment the line.
// $reCaptchaKeys [] = ['domain' => 'www.yourdevsite.com', 'sitekey' => 'ENTER_YOUR_DEVSITE_KEY_HERE', 'privatekey' => 'ENTER_YOUR_DEVPRIVATE_KEY_HERE'];

//set to true for the pages on which you wish to enable reCaptcha (you MUST also add the code snippet to the template!)
define('GOOGLE_RECAPTCHA_ASK_QUESTION', 'false');
define('GOOGLE_RECAPTCHA_BISN_SUBSCRIBE', 'false'); //Back In Stock Notification Plugin: https://github.com/torvista/Zen_Cart-Back_in_Stock_Notifications
define('GOOGLE_RECAPTCHA_CONTACT_US', 'false');
define('GOOGLE_RECAPTCHA_CREATE_ACCOUNT', 'false');
define('GOOGLE_RECAPTCHA_REVIEWS', 'false');//not needed if login is required

foreach ($reCaptchaKeys as $reCaptchaKey) {
    if ($_SERVER['HTTP_HOST']===$reCaptchaKey['domain']) {
        $sitekey = $reCaptchaKey['sitekey'];
        $privatekey = $reCaptchaKey['privatekey'];
        break;
    }
}
