<?php

declare(strict_types=1);
/**
 * Plugin Google reCaptcha
 * https://github.com/torvista/Zen_Cart-Google_reCAPTCHA
 * @license https://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @updated  $Id: torvista 14 Feb 2025
 */

//UNCOMMENT AND ENTER YOUR SITE DETAILS HERE
$reCaptchaKeys[] = ['domain' => 'www.yourdomain.whatever', 'siteKey' => 'ENTER_YOUR_SITE_KEY_HERE', 'secretKey' => 'ENTER_YOUR_PRIVATE_KEY_HERE'];
//You may add more sites and keys to the array of domain/sitekey/privatekey, for example, if you want to use the same code on a local and production server: each one needs their own keys from Google. Add them into the next line and uncomment the line.
//$reCaptchaKeys[] = ['domain' => 'www.yourdomain.local', 'siteKey' => 'ENTER_YOUR_SITE_KEY_HERE', 'secretKey' => 'ENTER_YOUR_PRIVATE_KEY_HERE'];

//set to 'true' for the pages on which you wish to enable reCaptcha (remember to add the code snippet to the template!)
define('GOOGLE_RECAPTCHA_ASK_QUESTION', 'true');
define('GOOGLE_RECAPTCHA_BISN_SUBSCRIBE', 'true'); //Back In Stock Notification Plugin: https://github.com/torvista/Zen_Cart-Back_in_Stock_Notifications
define('GOOGLE_RECAPTCHA_CONTACT_US', 'true');
define('GOOGLE_RECAPTCHA_CREATE_ACCOUNT', 'true');
define('GOOGLE_RECAPTCHA_LOGIN', 'false');
define('GOOGLE_RECAPTCHA_REVIEWS', 'false'); // not needed if login is required to write a Review

$reCaptchaSiteKey = '';
$reCaptchaSecretKey = '';
foreach ($reCaptchaKeys as $reCaptchaKey) {
    if ($reCaptchaKey['domain'] === 'www.yourdomain.whatever' ||
        $reCaptchaKey['siteKey'] === 'ENTER_YOUR_SITE_KEY_HERE' ||
        $reCaptchaKey['secretKey'] === 'ENTER_YOUR_PRIVATE_KEY_HERE') {
        continue;
    }
    if ($_SERVER['HTTP_HOST'] === $reCaptchaKey['domain']) {
        $reCaptchaSiteKey = $reCaptchaKey['siteKey'];
        $reCaptchaSecretKey = $reCaptchaKey['secretKey'];
        break;
    }
}
