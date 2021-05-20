<?php //Plugin Google reCaptcha
/*
 * AUTHOR:
 *  David Allen 2015
 *  torvista 2021
 */

//EXAMPLE FORMAT:
//$reCaptchaKeys[] = ['domain' => 'www.yoursite.com', 'sitekey' => 'ENTER_YOUR_SITE_KEY_HERE', 'privatekey' => 'ENTER_YOUR_PRIVATE_KEY_HERE'];

//ENTER YOUR SITE DETAILS HERE
//$reCaptchaKeys[] = ['domain' => 'www.yoursite.com', 'sitekey' => 'ENTER_YOUR_SITE_KEY_HERE', 'privatekey' => 'ENTER_YOUR_PRIVATE_KEY_HERE'];
//You may add more sites and keys to this array, for different servers, each one needs their own keys from Google
// $reCaptchaKeys [] = ['domain' => 'www.yourdevsite.com', 'sitekey' => 'ENTER_YOUR_DEVSITE_KEY_HERE', 'privatekey' => 'ENTER_YOUR_DEVPRIVATE_KEY_HERE'];

//set to true for the pages on which you wish to enable reCaptcha (don't forget to add the code snippet to the template!)
const GOOGLE_RECAPCHTA_ASK_QUESTION = 'false';
const GOOGLE_RECAPCHTA_CONTACT_US = 'false';
const GOOGLE_RECAPCHTA_CREATE_ACCOUNT = 'false';
const GOOGLE_RECAPCHTA_REVIEWS = 'false';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

foreach ($reCaptchaKeys as $reCaptchaKey) {
    if ($_SERVER['HTTP_HOST']===$reCaptchaKey['domain']) {
        $sitekey = $reCaptchaKey['sitekey'];
        $privatekey = $reCaptchaKey['privatekey'];
        break;
    }
}

/**
 * Creates the challenge HTML.
 * This is called from the browser, and the resulting reCAPTCHA HTML widget
 * is embedded within the HTML form it was called from.
 * @param bool $fieldset Should the challenge be wrapped in a fieldset (optional, default is false)
 * @param string $theme Should the reCaptcha be shown in light or dark theme (optional, default is light)
 * @param string $size Should the reCaptcha be shown in normal or compact size (optional, default is normal)
 * @param string $style Add as css style to the reCaptcha div (optional)
 * @return string - The HTML to be embedded in the form.
 */
function recaptcha_get_html($fieldset = false, $theme = 'light', $size = 'normal', $style = null): string {
    global $current_page_base, $sitekey;

// supported languages updated 4/4/2021: https://developers.google.com/recaptcha/docs/language
    $reCaptcha_languages = ['af', 'am', 'ar', 'az', 'bg', 'bn', 'ca', 'cs', 'da', 'de', 'de-AT', 'de-CH', 'el', 'en', 'en-GB', 'es', 'es-419', 'et', 'eu', 'fa', 'fi', 'fil', 'fr', 'fr-CA', 'gl', 'gu', 'hi', 'hr', 'hu', 'hy', 'id', 'is', 'it', 'iw', 'ja', 'ka', 'kn', 'ko', 'lo', 'lt', 'lv', 'ml', 'mn', 'mr', 'ms', 'nl', 'no', 'pl', 'pt', 'pt-BR', 'pt-PT', 'ro', 'ru', 'si', 'sk', 'sl', 'sr', 'sv', 'sw', 'ta', 'te', 'th', 'tr', 'uk', 'ur', 'vi', 'zh-CN', 'zh-HK', 'zh-TW', 'zu'];

    switch (true) {
        case ($current_page_base==='ask_a_question' && GOOGLE_RECAPCHTA_ASK_QUESTION==='true'):
        case ($current_page_base==='contact_us' && GOOGLE_RECAPCHTA_CONTACT_US==='true'):
        case (((USE_SPLIT_LOGIN_MODE === 'True' && $current_page_base==='create_account') || (USE_SPLIT_LOGIN_MODE === 'False' && $current_page_base==='login')) && GOOGLE_RECAPCHTA_CREATE_ACCOUNT==='true'):
        case ($current_page_base==='product_reviews_write' && GOOGLE_RECAPCHTA_REVIEWS==='true'):
            $recaptcha_html = '';
            break;
        default:
            $recaptcha_html = '<!-- reCaptcha disabled for this page: ' . $current_page_base . ' -->';
    }

    if (empty($sitekey) || $sitekey==='ENTER_YOUR_SITE_KEY_HERE') {
        $recaptcha_html = '** reCaptcha error: Site Key not defined! ** ';
    } elseif ($recaptcha_html==='') {
        //structure of html output: <fieldset><script></script><div></div></fieldset>
        $lang = '?hl=' . (in_array($_SESSION['languages_code'], $reCaptcha_languages, true) ? $_SESSION['languages_code']:'en');
        //$recaptcha_html = '<script src="https://www.google.com/recaptcha/api.js' . $lang . '" async defer></script>' . "\n";//not working if www.google.com blocked
        $recaptcha_html = '<script src="https://www.recaptcha.net/recaptcha/api.js' . $lang . '" async defer></script>' . "\n";
        $parameters = '<div class="g-recaptcha" data-sitekey="' . $sitekey . '"';
        if ($theme!=='light') { // default is light
            $parameters .= ' data-theme="dark"';
        }
        if ($size!=='normal') { // default is normal
            $parameters .= ' data-size="compact"';
        }
        $style = $style!==null ? ' style="' . $style . '"':'';
        $parameters .= $style . '></div>' . "\n";
        $recaptcha_html .= $parameters . "\n";
        if ($fieldset!==null) {
            $recaptcha_html = '<fieldset>' . "\n" . $recaptcha_html . '</fieldset>' . "\n";
        }
    }
    return $recaptcha_html;
}
