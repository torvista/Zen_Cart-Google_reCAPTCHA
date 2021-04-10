<?php // Plugin Google reCaptcha
/**
 * @package plugins
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
/**
 * This file is only required for Zen Cart pre-1.53. From Zen Cart 1.53 onwards it may be deleted.
 */
if (!defined('IS_ADMIN_FLAG')) {
 die('Illegal Access');
}
if (!file_exists('init_includes/init_observers.php')) {
    $autoLoadConfig[175][] = array('autoType' => 'class',
            'loadFile' => 'observers/auto.google_recaptcha_observer.php');
    $autoLoadConfig[175][] = array('autoType' => 'classInstantiate',
            'className' => 'zcObserverGoogleRecaptchaObserver',
            'objectName' => 'zcObserverGoogleRecaptchaObserver');
}