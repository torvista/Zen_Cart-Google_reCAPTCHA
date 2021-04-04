Google reCAPTCHA for Zen Cart v3.4
===================================================

Released under the GPL License 2.0

This Plugin inserts a Google reCAPTCHA v2 into the Contact-us page, Create Account page and Write a Review page to try to stop automated spam submissions.


Files included with this Plugin:
================================
	/includes/auto_loaders/config.google_recaptcha.php
	/includes/classes/observers/class.google_recaptcha.php
	/includes/classes/observers/google/autoload.php
	/includes/classes/observers/google/ReCaptcha/Response.php
	/includes/classes/observers/google/ReCaptcha/ReCaptcha.php
	/includes/classes/observers/google/ReCaptcha/RequestMethod.php
	/includes/classes/observers/google/ReCaptcha/RequestParameters.php
	/includes/classes/observers/google/ReCaptcha/RequestMethod/Curl.php
	/includes/classes/observers/google/ReCaptcha/RequestMethod/Post.php
	/includes/classes/observers/google/ReCaptcha/RequestMethod/Socket.php
	/includes/classes/observers/google/ReCaptcha/RequestMethod/SocketPost.php
	/includes/functions/extra_functions/recaptchalib.php
	/includes/languages/english/extra_definitions/reCaptcha.php
	/includes/templates/YOUR_TEMPLATE/templates/tpl_contact_us_default.php
	/includes/templates/YOUR_TEMPLATE/templates/tpl_modules_create_account.php
	/includes/templates/YOUR_TEMPLATE/templates/tpl_product_reviews_write_default.php
	/licence.txt --- GPL License 2.0
	/README-Google-reCAPTCHA.txt - this file
	
THEN if you're using v139 or v150 or v155 you'll want to ALSO copy over the files from the v139-only or v150-only or v155-only subdir, AFTER copying the files above.

Installation for all versions:
==============================
Step 1
	Go to https://www.google.com/recaptcha/admin and create the Google reCAPTCHA (v2) keys for your website
Step 2
	Open the file /includes/functions/extra_functions/recaptchalib.php and insert the public and private keys you got in Step 1. They need to go on lines 9 and 10

Now follow the appropriate steps for your Zen Cart version, below

Installation for Zen Cart version v1.5.5/v1.5.6
========================================
Step 3
 	Since the responsive_classic files are new to v1.5.5 there are modified copies of those files included in the v155-only folder.
 	Also, since the template_default files in v1.5.5 were changed a lot to modernize how error messages and HTML field types are presented, the v155-only folder also contains "classic" template files, which are basically the template_default equivalents for v1.5.5.

 	NOTE: In all these cases, the ONLY change relevant to this plugin is that the following line has been added to the form in each of these template files. You could easily add it yourself wherever you wish the Recaptcha box to display:

 	<?php echo recaptcha_get_html(); ?>


Installation for Zen Cart Version 1.5.4
=======================================
Step 3
	In order to display the reCAPTCHA on the webpage the following line needs to be added to the template file for that page. 	
		<?php echo recaptcha_get_html(); ?>
	See below for optional parameters to add to this line.
	If you haven't made changes to those template files you can use the included template files (in /includes/templates/YOUR_TEMPLATE/templates/) which have the line already added.
	Otherwise add the line in manually.
		For the Contact Us page (tpl_contact_us_default.php), I suggest adding it at about line 74 (just after the enquiry textarea)
		For the Create Account page (tpl_modules_create_account.php), I suggest adding it at about line 174 (just after the password confirmation) 
		For the Product Review page (tpl_product_reviews_default.php), I suggest adding it at about line 68 (just after the review_text textarea)

Step 4
	Upload all files to your server and it should all just work.


Instalation for Zen Cart Versions 1.5.1 to 1.5.4
================================================
Follow steps 1 and 2 from the instructions above.
Step 3	
	Do not use the included template files, instead manually add the <?php echo recaptcha_get_html(); ?> to your own template files


Instalation for Zen Cart Versions prior to 1.5.1
================================================

Follow steps 1 and 2 from the instructions above.
Step 3	
	Do not use the included template files, instead manually add the <?php echo recaptcha_get_html(); ?> to your own template files
Step 4
	Version 1.5.1 added notifier hooks to core files explicitly for CAPTCHA checking. So for versions prior to this these hooks have to added-in manually.
	If you haven't made any changes to these files you can use the files in the pre-v1.5.1 folder.
	To make the change manually:
4a:	In /includes/modules/pages/contact_us/header_php.php, at around line 19 you should see the line:
			$zc_validate_email = zen_validate_email($email_address);
		immediately after that add in the following code:
			$zco_notifier->notify('NOTIFY_CONTACT_US_CAPTCHA_CHECK');
		then change the line below from 
			if ($zc_validate_email and !empty($enquiry) and !empty($name)) {
		to
			if ($zc_validate_email and !empty($enquiry) and !empty($name) and $error == false) {
4b:	In /includes/modules/pages/product_reviews_write/header_php.php, at around line 54 you should see the line
			$error = false;
		immediately after that add in the following code:
			$zco_notifier->notify('NOTIFY_REVIEWS_WRITE_CAPTCHA_CHECK');
4c:	In /includes/modules/YOUR_TEMPLATE/create_account.php, at around line 248 you should see the line:
			if ($error == true) {
		immediately before that add in the following code:
			$zco_notifier->notify('NOTIFY_CREATE_ACCOUNT_CAPTCHA_CHECK');

Step 5
	Upload all files to your server and it should all just work.

Options
=======

The function recaptcha_get_html($fieldset=false, $theme='light', $size='normal') used in step 3 has three optional parameters 
	1	Fieldset flase/true (default is false)	whether to wrap the html in a fieldset - The create account page provided has this set to true.
	2	Theme	light/dark (default is light)	whether to use the light of dark theme for the reCaptcha
	3	Size	normal/compact (default is normal)	whether to use the normal or compact size for the reCaptcha
So to display a small dark reCaptcha surrounded by a fieldset you would use <?php recaptcha_get_html(true, 'dark', 'compact'); ?>

If your server doesn't allow the use of file_get_contents() with external urls, there are two other methods provided - fsockopen() and curl. To use them comment out the default method (line 31) and uncomment the approriate line (line 35 or 37) in /includes/classes/observers/class.google.recaptcha

Languages
=========

This plugin includes english by default. To use in another language you will need to copy /includes/languages/english/extra_definitions/reCaptcha.php to /includes/languages/YOUR_LANGUAGE/extra_definitions/reCaptcha.php and translate the error messages. In addition Google will display the reCaptcha in your chosen language if you add the parameter hl and a language code to /includes/functions/extra_functions/recaptchalib.php (see line 35 and French example on line 36). However if no language code is used Google will automatically detect the users language based on their browser settings (probably best to allow this rather than force a language).


	
Problems 
========
See the support page on the Zen Cart Forums - http://www.zen-cart.com/showthread.php?198357-Support-Thread-for-Google-reCAPTCHA 

Version History
===============
1.0	21 July 12	Initial Version
1.1	24 July 12	Corrected cut'n'paste error in /includes/modules/YOUR_TEMPLATE/create_account.php and updated Step 5 instructions to match.
2.0	21 Sept 12	Changed to use Zen Cart 1.5.1 notification hooks and an observer class. 
			Added detection for SSL pages.
			Uses zen_get_ip_address() instead of $_SERVER["REMOTE_ADDR"]. 
3.0	7 July 15	Completely new version created to use Google reCaptcha v2 ('I am not a robot')
			Classes are namespaced
			Optional curl and fsockopen methods included
3.1	7 July 15	Correct typo in Readme file, init $pages_to_check as array, correct misspelt directory name
3.2  Feb 2017 - Included modified v1.5.5 files for convenience.
3.3  Dec 2018 - updated for PHP 7.X
3.4  Apr 2019 - Updated to auto-disable if missing $publickey. Also included v139 files for convenience.
