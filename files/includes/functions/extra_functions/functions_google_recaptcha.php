<?php

declare(strict_types=1);
/**
 * Plugin Google reCaptcha
 * https://github.com/torvista/Zen_Cart-Google_reCAPTCHA
 * @license https://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: torvista 05 September 2024
 */

/*debugging
echo 'allow_url_fopen=' . ini_get('allow_url_fopen') . '<br>';
echo 'fsockopen=' . function_exists('fsockopen') . '<br>';
echo 'domain=' . $reCaptchaKey['domain'];
*/
/**
 * Creates the challenge HTML.
 * This is called from the browser, and the resulting reCAPTCHA HTML widget
 * is embedded within the HTML form it was called from.
 * @param bool $fieldset Should the challenge be wrapped in a fieldset (optional, default is false and sets a prior <br class="clearBoth"> instead)
 * @param string $theme Should the reCaptcha be shown in "light" or "dark" theme (optional, default is "light")
 * @param string $size Should the reCaptcha be shown in "normal" or "compact" size (optional, default is "normal")
 * @param string|null $style Add as a css style to the reCaptcha div (optional)
 * @return string - The Recaptcha box HTML to be embedded in the form.
 */
function recaptcha_get_html(bool $fieldset = false, string $theme = 'light', string $size = 'normal', string $style = null): string
{
    global $current_page_base, $sitekey;

// supported languages updated 21/03/2021: https://developers.google.com/recaptcha/docs/language
// to update/compare see spreadsheet in GitHub repository root
    $reCaptcha_languages = ['ar', 'af', 'am', 'hy', 'az', 'eu', 'bn', 'bg', 'ca', 'zh-HK', 'zh-CN', 'zh-TW', 'hr', 'cs', 'da', 'nl', 'en-GB', 'en', 'et', 'fil', 'fi', 'fr', 'fr-CA', 'gl', 'ka', 'de', 'de-AT', 'de-CH', 'el', 'gu', 'iw', 'hi', 'hu', 'is', 'id', 'it', 'ja', 'kn', 'ko', 'lo', 'lv', 'lt', 'ms', 'ml', 'mr', 'mn', 'no', 'fa', 'pl', 'pt', 'pt-BR', 'pt-PT', 'ro', 'ru', 'sr', 'si', 'sk', 'sl', 'es', 'es-419', 'sw', 'sv', 'ta', 'te', 'th', 'tr', 'uk', 'ur', 'vi', 'zu', ];
    $recaptcha_html = '';

    switch (true) {
        case ($current_page_base==='ask_a_question' && GOOGLE_RECAPTCHA_ASK_QUESTION==='true'):
        case ($current_page_base==='contact_us' && GOOGLE_RECAPTCHA_CONTACT_US==='true'):
        case (((USE_SPLIT_LOGIN_MODE === 'True' && $current_page_base==='create_account') || (USE_SPLIT_LOGIN_MODE === 'False' && $current_page_base==='login')) && GOOGLE_RECAPTCHA_CREATE_ACCOUNT==='true'):
        case ($current_page_base==='product_reviews_write' && GOOGLE_RECAPTCHA_REVIEWS==='true'):

        //BISN bof
        case ($current_page_base==='product_info' && GOOGLE_RECAPTCHA_BISN_SUBSCRIBE==='true'):
        case ($current_page_base==='back_in_stock_notification_subscribe' && GOOGLE_RECAPTCHA_BISN_SUBSCRIBE==='true'):
        // add any other product type info pages here
        //product kits
        case ($current_page_base==='product_kit_info' && GOOGLE_RECAPTCHA_BISN_SUBSCRIBE==='true'):
            break;
        //BISN eof

        default:
            $recaptcha_html = '<!-- reCaptcha not enabled for this page ("' . $current_page_base . '") -->';
    }

    if (empty($sitekey) || $sitekey==='ENTER_YOUR_SITE_KEY_HERE') {
        $recaptcha_html = '** reCaptcha error: Site Key not defined! ** ';
    } elseif ($recaptcha_html === '') {

        // The structure of the html output is
        // <br class="clearBoth"><div id="recaptcha"><script></script><div class="g-recaptcha">recaptcha</div></div>
        // or
        // <fieldset id="recaptcha"><script></script><div class="g-recaptcha">recaptcha</div></fieldset>

        // Recaptcha language: default to en if zc language two-letter code not in recaptcha supported languages
        $lang = '?hl=' . (in_array($_SESSION['languages_code'], $reCaptcha_languages, true) ? $_SESSION['languages_code'] : 'en');

        //$recaptcha_html = '<script src="https://www.google.com/recaptcha/api.js' . $lang . '" async defer></script>' . "\n";//not working if www.google.com blocked
        $recaptcha_html = '<script src="https://www.recaptcha.net/recaptcha/api.js' . $lang . '" async defer></script>' . "\n";
        $recaptcha_html .= '<div class="g-recaptcha" data-sitekey="' . $sitekey . '"';
        if ($theme !== 'light') { // default is light
            $recaptcha_html .= ' data-theme="dark"';
        }
        if ($size !== 'normal') { // default is normal
            $recaptcha_html .= ' data-size="compact"';
        }
        if ($style !== null) {
            $recaptcha_html .= ' style="' . $style . '"';
        }
        $recaptcha_html .=  '></div>' . "\n";

        if ($fieldset) {
            $recaptcha_html = '<fieldset id="recaptcha">' . "\n" . $recaptcha_html . '</fieldset>' . "\n";
        } else {
            $recaptcha_html = '<br class="clearBoth"><div id="recaptcha">' . "\n" . $recaptcha_html . "\n" . '</div>' . "\n";
        }
    }
    return $recaptcha_html;
}
