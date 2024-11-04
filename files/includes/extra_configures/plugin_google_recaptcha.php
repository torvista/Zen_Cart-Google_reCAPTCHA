<?php

declare(strict_types=1);
/**
 * Plugin Google reCaptcha
 * https://github.com/torvista/Zen_Cart-Google_reCAPTCHA
 * @license https://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @updated  $Id: torvista 2024 11 04
 */

//ENTER YOUR SITE DETAILS HERE
//$reCaptchaKeys[] = ['domain' => 'www.yourdomain.whatever', 'sitekey' => 'ENTER_YOUR_SITE_KEY_HERE', 'privatekey' => 'ENTER_YOUR_PRIVATE_KEY_HERE'];
//You may add more sites and keys to the array of domain/sitekey/privatekey, for example if you want to use the same code on a local and production server: each one needs their own keys from Google. Add them into the next line and uncomment the line.
//$reCaptchaKeys[] = ['domain' => 'www.yourdomain.local', 'sitekey' => 'ENTER_YOUR_SITE_KEY_HERE', 'privatekey' => 'ENTER_YOUR_PRIVATE_KEY_HERE'];



//set to 'true' for the pages on which you wish to enable reCaptcha (don't forget to add the code snippet to the template!)
define('GOOGLE_RECAPTCHA_ASK_QUESTION', 'true');
define('GOOGLE_RECAPTCHA_BISN_SUBSCRIBE', 'false'); //Back In Stock Notification Plugin: https://github.com/torvista/Zen_Cart-Back_in_Stock_Notifications
define('GOOGLE_RECAPTCHA_CONTACT_US', 'true');
define('GOOGLE_RECAPTCHA_CREATE_ACCOUNT', 'true');
define('GOOGLE_RECAPTCHA_REVIEWS', 'false');//not needed if login required

$reCaptchaSiteKey = '';
$reCaptchaPrivateKey = '';
foreach ($reCaptchaKeys as $reCaptchaKey) {
    if ($reCaptchaKey['domain'] === 'www.yourdomain.whatever' ||
        $reCaptchaKey['sitekey'] === 'ENTER_YOUR_SITE_KEY_HERE' ||
        $reCaptchaKey['privatekey'] === 'ENTER_YOUR_PRIVATE_KEY_HERE') {
        break;
    }
    if ($_SERVER['HTTP_HOST'] === $reCaptchaKey['domain']) {
        $reCaptchaSiteKey = $reCaptchaKey['sitekey'];
        $reCaptchaPrivateKey = $reCaptchaKey['privatekey'];
        break;
    }
}
