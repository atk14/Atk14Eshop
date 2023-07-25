<?php
/**
 * Either some parts of ATK14 system (i.e. mailing subsystem) or some third party libs
 * could be configured by constants or variables.
 * 
 * This file is the right place to do such configuration.
 *
 * You can inspect all ATK14 application`s constants in atk14/default_settings.php
 * 
 * All the application constants should be inspected by calling:
 *	$ ./scripts/dump_settings
 * 
 * A certain constant should be inspected this way:
 *	$ ./scripts/dump_settings DEFAULT_EMAIL
 */

definedef("DEFAULT_EMAIL","your@email.com");
definedef("ATK14_ADMIN_EMAIL",DEFAULT_EMAIL); // the address for sending error reports and so on...

definedef("ATK14_APPLICATION_NAME","ATK14 Eshop");
definedef("ATK14_APPLICATION_DESCRIPTION","Yet another application running on ATK14 Framework");

definedef("ATK14_HTTP_HOST",PRODUCTION ? "eshop.atk14.net" : "atk14eshop.localhost");

date_default_timezone_set('Europe/Prague');

definedef("USING_BOOTSTRAP4",true);
definedef("USING_FONTAWESOME",true);

definedef("REDIRECT_TO_SSL_AUTOMATICALLY",PRODUCTION);

// Automatic redirection to the ATK14_HTTP_HOST
definedef("REDIRECT_TO_CORRECT_HOSTNAME_AUTOMATICALLY",false);

// If you don't want to let users to register freely (e.g. your app is an closed alpha),
// set the constant INVITATION_CODE_FOR_USER_REGISTRATION.
// See app/forms/users/create_new_form.php for more info
// definedef("INVITATION_CODE_FOR_USER_REGISTRATION","some great secret");

// Or if you don't want to let users to register at all, set USER_REGISTRATION_ENABLED to false.
definedef("USER_REGISTRATION_ENABLED",true);

definedef("PUPIQ_API_KEY","101.DemoApiKeyForAccountWithLimitedFunctions");
definedef("PUPIQ_HTTPS",REDIRECT_TO_SSL_AUTOMATICALLY);
//
definedef("WEBP_FORMAT_SUPPORTED",true);

definedef("ARTICLE_BODY_MAX_WIDTH",825);

definedef("SIGN_UP_FOR_NEWSLETTER_ENABLED",true);

definedef("CONSIDER_GENDER_ID_FIELD",true);

definedef("ALLOW_STATE_IN_ADDRESS",false);

// == hCaptcha ==
// If these two constant are properly defined (see https://github.com/atk14/HcaptchaField#installation),
// the hcaptcha field is being automatically added into the contact form...
// define("HCAPTCHA_SITE_KEY","");
// define("HCAPTCHA_SECRET_KEY","");

// == reCAPTCHA ==
// Or if these two constant are properly defined (see https://github.com/atk14/RecaptchaField#installation),
// the re-captcha field is being automatically added into the contact form.
// define("RECAPTCHA_SITE_KEY","");
// define("RECAPTCHA_SECRET_KEY","");

definedef("TEXTMIT_API_KEY","123.aaa.bbb.ccc...");

// Temporary files uploads (these settings effects use of AsyncFileField)
// definedef("TEMPORARY_FILE_UPLOADS_ENABLED",true);
// definedef("TEMPORARY_FILE_UPLOADS_DIRECTORY",__DIR__ . "/../tmp/temporary_file_uploads/");
// definedef("TEMPORARY_FILE_UPLOADS_MAX_FILESIZE",512 * 1024 * 1024); // 512MB
// definedef("TEMPORARY_FILE_UPLOADS_MAX_AGE", 2 * 60 * 60); // 2 hours

definedef("CATALOG_ID_REGEXP",'/^[0-9A-Z_.\/-]{1,}$/i'); // see app/fields/catalog_id_field.php
definedef("CATALOG_ID_AUTO_UPPERIZE",true);

definedef("INTERNAL_PRICE_DECIMALS",6);

definedef("DEFAULT_PRICELIST","default");
definedef("DEFAULT_BASE_PRICELIST","base");

definedef("SAME_BASKET_IN_ALL_REGIONS",true);

definedef("DATA_DIRECTORY",__DIR__ . "/../data/");

definedef("DIGITAL_CONTENTS_DIRECTORY",DATA_DIRECTORY . "/digital_contents/");

definedef("PAYMENT_QR_CODES_ENABLED",true);

definedef("SIDEBAR_MENU_ENABLED",false);

definedef("TECHNICAL_SPECIFICATION_KEY_CREATION_ENABLED",true);

definedef("OFFER_BANK_TRANSFER_IF_ONLINE_TRANSACTION_FAILS",true);

definedef("PRODUCT_CAN_BE_ORDERED_FROM_CARD_LIST",false);

// To enable the "Online payment via testing payment gateway" payment method, a proper API Key for the Testing Payment Gateway must be defined
// definedef("TEST_PAYMENT_GATEWAY_API_KEY","10.atk14eshop.kbjQB83v9ylSV4L7D0cmgKfEGrNuie5o");

// The SessionStorer's check cookie is disabled here.
// A cookie from CookieConsent is set automatically in ApplicationBaseController. This cookie acts like a check cookie.
definedef("SESSION_STORER_COOKIE_NAME_CHECK","");

if(DEVELOPMENT || TEST){
	// a place for development and testing environment settings

	ini_set("display_errors","1");
}

if(PRODUCTION){
	// a place for production environment settings

	if(php_sapi_name()!="cli"){
		ini_set("display_errors","0");
	}
}
