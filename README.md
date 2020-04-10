# Wordpress-APM-Agent-Elasticsearch
A (unofficial) WordPress plugin to send data to APM agent of Elasticsarch.

## What?
There is still no official APM Agent Elasticsearch for PHP or Wordpress.
This plugin sends Wordpress metrics to the AMP Server.

## Usage

1. Install this plugin by cloning or copying this repository to your `wp-contents/plugins` folder
2. Configure your CONSTANTS as explained below
2. Activate the plugin through the WordPress admin interface

**Note:** this plugin does not do anything by default and has no admin interface. Your CONSTANTS must be configured first.

## Configuration
Add these constants to your `wp-config.php`, and Replace the values according to the configuration of your APM SERVER.

```php
define('APM_APPNAME', 'app-name');
define('APM_APPVERSION', '1.0.0');
define('APM_SERVERURL', 'http://apm-server:8200');
define('APM_SECRETTOKEN', 'abcd');
define('APM_ENVIRONMENT', 'development');
define('APM_ACTIVE', true);
```

## License
The Wordpress APM agent Elasticsearch plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
