<?php

declare(strict_types=1);
/**
 * Plugin Google reCaptcha
 * https://github.com/torvista/Zen_Cart-Google_reCAPTCHA
 * @license https://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: torvista 05 September 2024
 */
class zcObserverGoogleRecaptchaObserver extends base {
    public function __construct() {
        $pages_to_check = [];
        if (defined('GOOGLE_RECAPTCHA_ASK_QUESTION') && GOOGLE_RECAPTCHA_ASK_QUESTION==='true') {
            $pages_to_check[] = 'NOTIFY_ASK_A_QUESTION_CAPTCHA_CHECK';
        }
        if (defined('GOOGLE_RECAPTCHA_BISN_SUBSCRIBE') && GOOGLE_RECAPTCHA_BISN_SUBSCRIBE==='true') {
            $pages_to_check[] = 'NOTIFY_BISN_SUBSCRIBE_CAPTCHA_CHECK';
        }
        if (defined('GOOGLE_RECAPTCHA_CONTACT_US') && GOOGLE_RECAPTCHA_CONTACT_US==='true') {
            $pages_to_check[] = 'NOTIFY_CONTACT_US_CAPTCHA_CHECK';
        }
        if (defined('GOOGLE_RECAPTCHA_CREATE_ACCOUNT') && GOOGLE_RECAPTCHA_CREATE_ACCOUNT==='true') {
            $pages_to_check[] = 'NOTIFY_CREATE_ACCOUNT_CAPTCHA_CHECK';
        }
        if (defined('GOOGLE_RECAPTCHA_REVIEWS') && GOOGLE_RECAPTCHA_REVIEWS==='true') {
            $pages_to_check[] = 'NOTIFY_REVIEWS_WRITE_CAPTCHA_CHECK';
        }
        if (count($pages_to_check) > 0) $this->attach($this, $pages_to_check);
    }

    /**
     * @param $class
     * @param $eventID
     * @param  array  $paramsArray
     * @return bool
     */
    public function update(&$class, $eventID, array $paramsArray = []): bool
    {
        global $messageStack, $error, $privatekey; //"$error" needs to be checked in the page header after executing the notifier to send/accept or reject form.

        require_once __DIR__ . '/google/autoload.php';

        switch (true) {
            case (ini_get('allow_url_fopen')!=='1' && function_exists('fsockopen')) :
                // if file_get_contents() is disabled, this alternative request method uses fsockopen().
                $method = 'SocketPost';
                $recaptcha = new \ReCaptcha\ReCaptcha($privatekey, new \ReCaptcha\RequestMethod\SocketPost());
                break;
            case (!function_exists('fsockopen')) :
                // if fsockopen is disabled, this alternative request method uses Curl().
                $method = 'CurlPost';
                $recaptcha = new \ReCaptcha\ReCaptcha($privatekey, new \ReCaptcha\RequestMethod\CurlPost());
                break;
            default:
                $method = 'default';
                $recaptcha = new \ReCaptcha\ReCaptcha($privatekey);
        }
        // pages have a specific identifier so messageStack outputs any error message only on the page that was submitted
        $event_array = [
            'NOTIFY_ASK_A_QUESTION_CAPTCHA_CHECK' => 'contact',  // note: Ask a Question DOES use identifier 'contact' for messageStack: https://github.com/zencart/zencart/issues/6143
            'NOTIFY_CONTACT_US_CAPTCHA_CHECK' => 'contact',
            'NOTIFY_CREATE_ACCOUNT_CAPTCHA_CHECK' => 'create_account',
            'NOTIFY_BISN_SUBSCRIBE_CAPTCHA_CHECK' => 'bisn_subscribe',
            'NOTIFY_REVIEWS_WRITE_CAPTCHA_CHECK' => 'review_text'
        ];

//uncomment for debugging
//$messageStack->add('contact', 'allow_url_fopen=' . ini_get('allow_url_fopen') . '<br>' . 'fsockopen=' . function_exists('fsockopen') . '<br>' . '$method used=' . $method);

        if (isset($_POST['g-recaptcha-response'])) {
            $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
            if (!$resp->isSuccess()) {
                $errorArray = [];
                $errors = $resp->getErrorCodes();
                //replace Google error codes with local language strings
                if (in_array('missing-input-secret', $errors, true)) {
                    $errorArray[] = RECAPTCHA_MISSING_INPUT_SECRET;
                }
                if (in_array('invalid-input-secret', $errors, true)) {
                    $errorArray[] = RECAPTCHA_INVALID_INPUT_SECRET;
                }
                if (in_array('missing-input-response', $errors, true)) {
                    $errorArray[] = RECAPTCHA_MISSING_INPUT_RESPONSE;
                }
                if (in_array('invalid-input-response', $errors, true)) {
                    $errorArray[] = RECAPTCHA_INVALID_INPUT_RESPONSE;
                }
                if (in_array('bad-request', $errors, true)) {
                    $errorArray[] = RECAPTCHA_BAD_REQUEST;
                }
                if (in_array('timeout-or-duplicate', $errors, true)) {
                    $errorArray[] = RECAPTCHA_TIMEOUT_OR_DUPLICATE;
                }
                $error_messages = implode(', ', $errorArray);
                $messageStack->add($event_array[$eventID], $error_messages);
                $error = true;
            } else {
                $error = false;
            }
        } else {
            $messageStack->add($event_array[$eventID], RECAPTCHA_MISSING_INPUT_RESPONSE);
            $_POST['g-recaptcha-response'] = 'no recaptcha response';
            $error = true;
        }
        return $error;
    }
}
