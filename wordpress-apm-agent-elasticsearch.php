<?php

  /*
    * Plugin Name: Wordpress APM Agent Elasticsearch
    * Plugin URI: https://github.com/matheusevangelista/Wordpress-APM-Agent-Elasticsearch
    * Description: A (unofficial) WordPress plugin to send data to APM agent of Elasticsarch.
    * Version: 1.0.4
    * Author: Matheus Evangelista
    * Author URI: https://github.com/matheusevangelista
    * License: MIT
  */

  if ( ! defined( 'WP_APM_PLUGIN_PATH' ) ) {
    define( 'WP_APM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
  }

  require_once( WP_APM_PLUGIN_PATH. 'vendor/autoload.php' );
  require_once( WP_APM_PLUGIN_PATH . 'classes/APM.php' );

  use GuzzleHttp\Psr7;
  use GuzzleHttp\Exception\ConnectException;
  use PhilKra\Agent;

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
    define( 'APM_SERVERURL', 'http://apm-server.com/8200' );
  }

  if ( ! defined( 'APM_SECRETTOKEN' ) ) {
    define( 'APM_SECRETTOKEN', '' );
  }

  if ( ! defined( 'APM_ACTIVE' ) ) {
    define( 'APM_ACTIVE', false );
  }

  if ( ! defined( 'APM_ENVIRONMENT' ) ) {
    define( 'APM_ENVIRONMENT', 'local' );
  }

  try {

    $config = [
      'appName'     => APM_APPNAME,
      'appVersion'  => APM_APPVERSION,
      'serverUrl'   => APM_SERVERURL,
      'secretToken' => APM_SECRETTOKEN,
      'active'      => APM_ACTIVE,
      'hostname'    => gethostname(),
      'environment' => APM_ENVIRONMENT,
      'env'         => ['DOCUMENT_ROOT', 'REMOTE_ADDR', 'REMOTE_USER', 'APM_ENVIRONMENT'],
      'timeout' => 2,
      'httpClient' => [
        'connect_timeout' => 2,
        'timeout' => 2
      ]
    ];

    $agent = new Agent($config);

    new APM($agent);

  }catch(ConnectException $e){

  }catch(Exception $e){

  }

?>
