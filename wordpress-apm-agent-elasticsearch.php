<?php

  /*
    * Plugin Name: Wordpress APM Agent Elasticsearch
    * Plugin URI: https://github.com/matheusevangelista/Wordpress-APM-Agent-Elasticsearch
    * Description: A (unofficial) WordPress plugin to send data to APM agent of Elasticsarch.
    * Version: 1.0.2
    * Author: Matheus Evangelista
    * Author URI: https://github.com/matheusevangelista
    * License: MIT
  */

  require 'vendor/autoload.php';

  use GuzzleHttp\Psr7;
  use GuzzleHttp\Exception\ConnectException;

  if ( ! defined( 'WP_APM_PLUGIN_PATH' ) ) {
    define( 'WP_APM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
  }

  /**
   * Checking vars
   */

  if ( ! defined( 'APM_APPNAME' ) ) {
    define( 'APM_APPNAME', 'app-name' );
  }

  if ( ! defined( 'APM_APPVERSION' ) ) {
    define( 'APM_APPVERSION', '1.0.0' );
  }

  if ( ! defined( 'APM_SERVERURL' ) ) {
    define( 'APM_SERVERURL', 'http://apm-server/8200' );
  }

  if ( ! defined( 'APM_SECRETTOKEN' ) ) {
    define( 'APM_SECRETTOKEN', '' );
  }

  if ( ! defined( 'APM_ACTIVE' ) ) {
    define( 'APM_ACTIVE', true );
  }

  if ( ! defined( 'APM_ENVIRONMENT' ) ) {
    define( 'APM_ENVIRONMENT', 'local' );
  }

  require_once( WP_APM_PLUGIN_PATH . 'classes/APM.php' );

  try {

    new APM();

  }catch(ConnectException $e){

  }catch(Exception $e){

  }

?>
