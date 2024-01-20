# Google reCAPTCHA Plugin v3.7 for Zen Cart 1.5.8

Released under the GPL License 2.0.

This Plugin provides Google reCAPTCHA functionality (v2/v3), for optional use on the pages with user-entered forms: Ask A Question, Contact Us, Create Account and Write a Review. It should work for all versions for Zen Cart 1.51 onwards.

## Compatibility
For Zen Cart 1.5.8, tested on php 8.1/8.2/8.3  
For Zen Cart 1.5.7: see https://github.com/torvista/Zen_Cart-Google_reCAPTCHA/releases

## Installation

1. MERGE the new files to your TEST server. Some are new, some are core edits, some are template overrides. DO NOT BLINDLY COPY THE FILES!

**/includes/classes/observers/auto.google_recaptcha_observer.php**

Observer that watches the relevant page(s) that have contact forms.

**/includes/functions/extra_functions/functions_google_recaptcha.php**

This file **MUST** be modified by the user to add the website address (www.yoursite.whatever),  the Google Site key and Private key and also to enable/disable the use of the reCaptcha on individual pages.  
The details of this process are described below.

**/includes/languages/english/extra_definitions/reCaptcha.php**

The definitions of the error message texts shown when the captcha is not validated. Note that the text shown on the reCAPTCHA itself is Google-generated.

The following set of files come directly from the Google reCAPTCHA library on GitHub: https://github.com/google/recaptcha
The current version is tag v1.3.0 (newer versions may be available).
All files are unmodified from the folder /src.  
/includes/classes/observers/google/autoload.php  
/includes/classes/observers/google/ReCaptcha/ReCaptcha.php  
/includes/classes/observers/google/ReCaptcha/RequestMethod.php  
/includes/classes/observers/google/ReCaptcha/RequestParameters.php  
/includes/classes/observers/google/ReCaptcha/Response.php  
/includes/classes/observers/google/ReCaptcha/RequestMethod/Curl.php  
/includes/classes/observers/google/ReCaptcha/RequestMethod/CurlPost.php    
/includes/classes/observers/google/ReCaptcha/RequestMethod/Post.php  
/includes/classes/observers/google/ReCaptcha/RequestMethod/Socket.php  
/includes/classes/observers/google/ReCaptcha/RequestMethod/SocketPost.php

Where core files are modified, I rename the original file (suffixed .158 php) so that it is adjacent to the modified file to highlight that there is a modification, and for easy comparison/reference.
You do not need these/you may delete them/they do no harm/they are useful.

**files in \includes\templates\YOUR_TEMPLATE\etc**  
Rename YOUR_TEMPLATE to your template name, compare and merge.

2. The code snippet that generates the Captcha html is in the template files.
````
<?php //plugin Google reCaptcha
echo recaptcha_get_html(false, 'light', 'normal', 'margin:5px');
//eof plugin Google reCaptcha ?>
````
This reCaptcha function call has four optional parameters, all four in the above example can be omitted (“margin:5px” is not a default style).
a)	Wrap in a fieldset? false / true. Default is false.
b)	reCAPTCHA theme: light / dark. Default is light.
c)	reCAPTCHA size: normal (rectangular)/ compact (square). Default is normal.
d)	Additional styles for the container. These will not affect the reCaptcha, only the containing div.
Eg:
````
<?php echo recaptcha_get_html(); // no parameters: displays a light, normal-size (rectangular) reCAPTCHA ?>
````
````
<?php echo recaptcha_get_html(true, 'dark', 'compact'); // displays a dark, compact (square) reCAPTCHA surrounded by a fieldset ?>
````

3. By default, the reCAPTCHA is **disabled** on all pages: you need to enable each page in
/includes/functions/extra_functions/functions_google_recaptcha.php


4. An API key pair is required from Google are required to use the reCAPTCHA.

Go to
https://www.google.com/recaptcha/admin/create 
and create the Google reCAPTCHA keys for your domain. A key pair is linked to a specific domain.  Copy and save the two keys somewhere.

You may generate pairs for your production server, local server, development server…etc.  
All can be placed in the array in the functions file, so the correct pair will be automatically used for the correct domain. This allows testing in different environments without needing to change the pair definitions and keeping the file identical on all the sites.

5. Open the functions file for editing: 

**/includes/functions/extra_functions/functions_google_recaptcha.php** 

Paste the domain name, site and private keys where indicated, and set to 'true' the pages where you wish the reCAPTCHA to be used.
 The reCAPTCHA should work with no further configuration necessary.

## Language
The language used in the reCAPTCHA is generated by Google, and based on the shop session language or English.
The error messages are defined in the plugin language file.

## Back In Stock Notifications Plugin
https://github.com/torvista/Zen_Cart-Back_in_Stock_Notifications
01/20/2024: support for Recaptcha is now built-in.

## Problems
a) Triple-check your installation and re-read the documentation.

b) Review the reCaptcha FAQ:  
https://developers.google.com/recaptcha/docs/faq

c) The reCaptcha does not display: the api.js is not attempted to be downloaded/is not shown in the browser Developer Tools->Network and you have Content-Security-Policy implemented:  
https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP   
This is mentioned in the reCaptcha FAQ.
You will need to add the exceptions to the CSP Policy either at server or meta-tag level.  
The minimum for the reCaptcha seems to be
````
<meta http-equiv="Content-Security-Policy" content="default-src 'self';
script-src 'self' https: 'nonce-{NONCE}' https://ajax.googleapis.com/ https://www.recaptcha.net/;
child-src 'self' https://www.recaptcha.net/">
````
and this will  be additional to whatever is your already-working CSP policies/parameters as in this user example:  
https://www.zen-cart.com/showthread.php?198357-Support-Thread-for-Google-reCAPTCHA-plugin&p=1390588#post1390588

d) If your still cannot get it to work, post in the relevant thread on the Zen Cart Forums - https://www.zen-cart.com/showthread.php?198357-Support-Thread-for-Google-reCAPTCHA 

## Notes
a)	If the PHP environment has 'allow_url_fopen' disabled and so 'file_get_contents' does not work. The code will drop to an alternative method using fsockopen.
b)	If the PHP environment does not have 'fsockopen' available. The code will drop to an alternative method using cURL.

## Changelog
2024 01 20: torvista - Reviewed and reworked support for Back in Stock Notifications. Multiple minor fettling.

2023 August torvista - update the Google reCaptcha source to tag 1.3.0.  Add support for Back In Stock Notifications.

3.7 Nov 2022 torvista - Removed unnecessary header files for ZC158

3.6 Released as final version for Zen Cart 1.5.7

3.6 Oct 2022 torvista - Updated Readme for Content-Security-Policy. Added parameters type casting.

3.6 June 2022 torvista - added original template files for comparison, removed unneeded observer loader, updated readme.

3.6 May 2021 torvista - added template examples, sticky form fields, fix for reCaptcha not displaying when split login in use

3.5 Apr 2021 torvista – Updated with Google reCAPTCHA library 1.24

Custom code for Zen Cart removed from Google reCAPTCHA Library so it is a pure drop-in library.

Added support for multiple keys pairs: for use on production and testing servers without needing to change the defined key pairs.

Added options to enable/disable reCaptcha use per page: set in functions file.

Added checks for 'allow_url_fopen' and fsockopen being disabled, to automatically use alternative response methods.

Removed obsolete template files.

3.4 Apr 2019 - Updated to auto-disable if missing $publickey. Also included v139 files for convenience.

3.3 Dec 2018 - updated for PHP 7.X

3.2 Feb 2017 - Included modified v1.5.5 files for convenience.

3.1 7 July 15	Correct typo in Readme file, init $pages_to_check as array, correct misspelt directory name

3.0 7 July 15	Completely new version created to use Google reCaptcha v2 ('I am not a robot')
Classes are namespaced

Optional curl and fsockopen methods included

2.0	21 Sept 12	Changed to use Zen Cart 1.5.1 notification hooks and an observer class. 
Added detection for SSL pages.

Uses zen_get_ip_address() instead of $_SERVER["REMOTE_ADDR"]. 

1.1	24 July 12	Corrected cut'n'paste error in /includes/modules/YOUR_TEMPLATE/create_account.php and updated Step 5 instructions to match.

1.0	21 July 12	Initial Version
