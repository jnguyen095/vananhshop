<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// Custome
defined('MAX_PAGE_ITEM')		OR define('MAX_PAGE_ITEM', 20); // max page item
defined('CAT_TYPE_SALE')		OR define('CAT_TYPE_SALE', 1); // sale category
defined('ACTIVE')				OR define('ACTIVE', 1); // active
defined('HOT_PRODUCT')			OR define('HOT_PRODUCT', 1); // active
defined('INACTIVE')				OR define('INACTIVE', 0); // inactive
defined('PAYMENT_DELAY')		OR define('PAYMENT_DELAY', 2); // payment delay
defined('UPDATE')				OR define('UPDATE', 'update'); // crudaction: update
defined('DELETE')				OR define('DELETE', 'delete'); // crudaction: delete
defined('REFRESH')				OR define('REFRESH', 'refresh'); // crudaction: refresh
defined('ACTIVE_POST')			OR define('ACTIVE_POST', 'active'); // crudaction: active post
defined('INACTIVE_POST')		OR define('INACTIVE_POST', 'inactive'); // crudaction: inactive post
defined('NHADAT_BAN')			OR define('NHADAT_BAN', 'NHADAT_BAN');
defined('NHADAT_CHOTHUE')		OR define('NHADAT_CHOTHUE', 'NHADAT_CHOTHUE');
defined('USER_GROUP_STAFF')		OR define('USER_GROUP_STAFF', 3); // Staff
defined('USER_GROUP_CUSTOMER')	OR define('USER_GROUP_CUSTOMER', 2); // Customer
defined('USER_GROUP_ADMIN')		OR define('USER_GROUP_ADMIN', 1); // Admin
defined('USER_GROUP_ADMIN_CODE')		OR define('USER_GROUP_ADMIN_CODE', 'ADMIN'); // Admin


// Social IDs
defined('GOOGLE_MAP_KEY')		OR define('GOOGLE_MAP_KEY', 'AIzaSyCTRujHZaewV1ggtE6QIWY4xhgPnrODoZM'); // google map key https://nhatimchu.com
//defined('FACEBOOK_ID')			OR define('FACEBOOK_ID', '263683937369914'); // facebook id: login by facebook, share post: local
defined('FACEBOOK_ID')			OR define('FACEBOOK_ID', '339916999763026'); // facebook id: login by facebook, share post
defined('GOOGLE_ID')			OR define('GOOGLE_ID', '425783171151-utka0e2mvtbvjievajdgpkreat5162tq.apps.googleusercontent.com'); // google key: login by google: local
//defined('GOOGLE_ID')			OR define('GOOGLE_ID', '668102068187-t0edbdgdn957ahb2idfcvgccg9c8k3p0.apps.googleusercontent.com'); // google key: login by google

// defined('GOOGLE_ANALYTIC_ID')	OR define('GOOGLE_ANALYTIC_ID', 'G-XSFLVBPT63'); // Google Analytic production: https://nhatimchu.com
defined('GOOGLE_ANALYTIC_ID')	OR define('GOOGLE_ANALYTIC_ID', 'UA-105379684-2'); // Google Analytic local

// Product Package
defined("PRODUCT_STANDARD")		OR define('PRODUCT_STANDARD', 5); // Free product
defined("PRODUCT_VIP_0")		OR define('PRODUCT_VIP_0', 0); // Highest priority
defined("PRODUCT_VIP_1")		OR define('PRODUCT_VIP_1', 1); // 2nd priority
defined("PRODUCT_VIP_2")		OR define('PRODUCT_VIP_2', 2); // 3th priority
defined("PRODUCT_VIP_3")		OR define('PRODUCT_VIP_3', 3); // 4th priority

// Packages cost
defined("COST_STANDARD_PER_DAY")	OR define('COST_STANDARD_PER_DAY', 0); // Free product
defined("COST_VIP_0_PER_DAY")		OR define('COST_VIP_0_PER_DAY', 10000); // Highest priority
defined("COST_VIP_1_PER_DAY")		OR define('COST_VIP_1_PER_DAY', 5000); // 2nd priority
defined("COST_VIP_2_PER_DAY")		OR define('COST_VIP_2_PER_DAY', 3000); // 3th priority
defined("COST_VIP_3_PER_DAY")		OR define('COST_VIP_3_PER_DAY', 1000); // 4th priority

// Payment Type
defined("PAYMENT_DEPOSIT")		OR define('PAYMENT_DEPOSIT', 1);
defined("PAYMENT_WITHDRAW")		OR define('PAYMENT_WITHDRAW', -1);

defined("MAX_POST_PER_DAY")		OR define('MAX_POST_PER_DAY', 1);
defined("MAX_REFRESH_STANDARD_POST")		OR define('MAX_REFRESH_STANDARD_POST', 3);
defined("MAX_FREE_POST")			OR define('MAX_FREE_POST', 2);

// Order status
defined("ORDER_STATUS_NEW")		OR define('ORDER_STATUS_NEW', 'NEW');
defined("ORDER_STATUS_CANCEL")		OR define('ORDER_STATUS_CANCEL', 'CANCEL');
defined("ORDER_STATUS_CONFIRM")	OR define('ORDER_STATUS_CONFIRM', 'CONFIRMED');
defined("ORDER_STATUS_SHIPPING")	OR define('ORDER_STATUS_SHIPPING', 'SHIPPING');
defined("ORDER_STATUS_COMPLETED")	OR define('ORDER_STATUS_COMPLETED', 'COMPLETED');

// Email server configuration
defined("MAIL_PROTOCAL")		OR define('MAIL_PROTOCAL', "smtp");
defined("MAIL_HOST")			OR define('MAIL_HOST', "mail.nhadatancu.com");
defined("MAIL_SMTP_USER")		OR define('MAIL_SMTP_USER', "info@nhadatancu.com");
defined("MAIL_SMTP_PASS")		OR define('MAIL_SMTP_PASS', "p25khGAmY41P");
defined("MAIL_SMTP_PORT")		OR define('MAIL_SMTP_PORT', 587);

// Quotation
defined("QUOTE_STATUS_NEW")		OR define('QUOTE_STATUS_NEW', 1);
defined("QUOTE_STATUS_UPDATE")	OR define('QUOTE_STATUS_UPDATE', 2);
defined("QUOTE_STATUS_APPROVED")		OR define('QUOTE_STATUS_APPROVED', 3);

// Domain
defined("APP_DOMAIN")			OR define('APP_DOMAIN', 'http://localhost/coffeebean');


