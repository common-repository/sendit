<?php
/*
Plugin Name: Sendit WP Newsletter
Plugin URI: https://wpsendit.com
Description: Wordpress newsletter plugin. Sendit is a friendly and easy newsletter and mailing lists plugin for WordPress, born to make newsletter delivery management a great experience. Get ready for Sendit 3
Version: 2.5.1
Author: Giuseppe Surace
Author URI: https://wpsendit.com
*/

require_once plugin_dir_path( __FILE__ ).'libs/install-core.php';
require_once plugin_dir_path( __FILE__ ).'libs/actions.php';
require_once plugin_dir_path( __FILE__ ).'libs/markup.php';
require_once plugin_dir_path( __FILE__ ).'libs/admin/subscribers-list.php';
require_once plugin_dir_path( __FILE__ ).'libs/admin/admin-core.php';
require_once plugin_dir_path( __FILE__ ).'libs/extensions-handler.php';
require_once plugin_dir_path( __FILE__ ).'libs/import.php';
require_once plugin_dir_path( __FILE__ ).'libs/add-on/template-manager.php';
require_once plugin_dir_path( __FILE__ ).'libs/add-on/css-inliner.php';

//new folder filesystem pre setup
require_once plugin_dir_path( __FILE__ ).'libs/admin/meta-boxes.php';
require_once plugin_dir_path( __FILE__ ).'libs/frontend/frontend.php';
require_once plugin_dir_path( __FILE__ ).'libs/admin/migrations.php';

load_plugin_textdomain('sendit', false, basename(dirname(__FILE__)) . '/languages'); //thanks to Davide http://www.jqueryitalia.org

register_activation_hook( __FILE__, 'sendit_install' );
register_activation_hook( __FILE__, 'sendit_sampledata');

/* Display a notice that can be dismissed */

add_action('admin_notices', 'sendit_admin_notice');

function sendit_admin_notice() {
  global $sendit_db_version;

  $sendit_db_version = SENDIT_DB_VERSION;
  $installed_version = get_option('sendit_db_version');
  global $current_user ;
  $user_id = $current_user->ID;
  /* Check that the user hasn't already clicked to ignore the message */

  if ($sendit_db_version!=$installed_version) {
    echo '<div class="updated"><h2>Warning!</h2>';
    printf(__('You need to run Update of Sendit plugin table structure NOW!! | <a href="admin.php?page=update-sendit&upgrade_from_box=1">Click here to run process &raquo;</a>'), '');
    echo "</p></div>";
  }

  else

  {
    if ( ! get_user_meta($user_id, 'sendit_ignore') ) {
      echo '<div class="updated"><p>';
      printf(__('Your Sendit database table structure is currently updated to latest version '.SENDIT_DB_VERSION.' | <a href="%1$s">Hide this Notice</a>'), admin_url( 'admin.php?page=sendit/libs/admin/admin-core.php&sendit_ignore=0'));
      echo "</p></div>";
    }
  }






}

add_action('admin_init', 'sendit_ignore');

function sendit_ignore() {
  global $current_user;
  $user_id = $current_user->ID;
  /* If user clicks to ignore the notice, add that to their user meta */
  if ( isset($_GET['sendit_ignore']) && '0' == $_GET['sendit_ignore'] ) {
    add_user_meta($user_id, 'sendit_ignore', 'true', true);
  }
}


add_action('admin_notices', 'sendit_cron_notice');

function sendit_cron_notice() {
  global $sendit_db_version;
  //echo SENDIT_IMG_PATH;
  $sendit_db_version = SENDIT_DB_VERSION;
  $installed_version = get_option('sendit_db_version');
  global $current_user;
  $user_id = $current_user->ID;
  /* Check that the user hasn't already clicked to ignore the message */

  if(!get_user_meta($user_id, 'sendit_cron_ignore')){
    echo '<div class="updated" id="sendit-3-notice">
            <h3>'.__('Important notice for all users', 'sendit').'</h3>
            <span><b>'.__('We are working on Sendit 3.0.<br /> Big changes are coming and a new support team is ready and happy to help you!','sendit').'</b><br />
            We are working hard to fix and remove all warnings in order to getting ready for the V 3.<br />
            We are working too on our <a href="https://wpsendit.com/?utm_source=sendit_banner&utm_medium=plugin&utm_campaign=sendit_2019">brand new website</a> which will contain all Documentations / examples and where you can open tickets. The project is also on Github.<br />I strongly recommend to subscribe to our newsletter in order to stay updated and receive news. <br />
            <b>Thank you for your attention for your love and for your patience!</b><br /><br />
            <a target="_blank" title="Sendit 3" href="https://wpsendit.com/?utm_source=sendit_banner&utm_medium=plugin&utm_campaign=sendit_2019" class="button-primary">Stay update</a>

            <a class="button-secondary" href="admin.php?page=sendit/libs/admin/admin-core.php&sendit_cron_ignore=0">Hide Notice</a></span>';

      echo "</p></div>";
    }
  }

  add_action('admin_init', 'sendit_cron_ignore');

  function sendit_cron_ignore() {
    global $current_user;
    $user_id = $current_user->ID;
    /* If user clicks to ignore the notice, add that to their user meta */
    if ( isset($_GET['sendit_cron_ignore']) && '0' == $_GET['sendit_cron_ignore'] ) {
      add_user_meta($user_id, 'sendit_cron_ignore', 'true', true);
    }
  }


  add_action('wp_head', 'sendit_register_head');
  add_action('plugins_loaded','DisplayForm');
  add_action('admin_menu', 'gestisci_menu');

  add_action('init', 'sendit_custom_post_type_init');
  add_action('save_post', 'sendit_save_postdata');

  add_action('save_post', 'send_newsletter');

  ?>
