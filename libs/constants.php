<?php
global $wpdb;
/* file with all constants */
define('SENDIT_EMAIL_TABLE', $wpdb->prefix . "nl_email");
define('SENDIT_LIST_TABLE', $wpdb->prefix . "nl_liste");
define('SENDIT_VERSION', '2.5.1');
define('SENDIT_DB_VERSION', '2.5.1');
define('SENDIT_ASSETS_PATH', plugins_url() . '/sendit/assets/');
define('SENDIT_IMG_PATH', plugins_url() . '/sendit-workingcopy/images/');
?>
