# Wordpress APM Agent Elasticsearch
A (unofficial) WordPress plugin to send data to APM agent of [Elasticsearch](https://www.elastic.co).

## What?
There is still no official APM Agent Elasticsearch for PHP or Wordpress.
This plugin sends Wordpress metrics to the [APM Server](https://www.elastic.co/pt/apm).

## Usage

1. Install this plugin by [downloading](https://github.com/matheusevangelista/Wordpress-APM-Agent-Elasticsearch/releases/download/v1.0.1/wordpress-apm-agent-elasticsearch.zip), cloning or copying this repository to your `wp-contents/plugins` folder.
2. Install the plugin dependencies with [composer](https://getcomposer.org).
3. Configure your CONSTANTS as explained below.
4. Activate the plugin through the WordPress admin interface

**Note:** this plugin does not do anything by default and has no admin interface. Your CONSTANTS must be configured first.

## Configuration
Add these constants to your `wp-config.php`, and replace the values according to the configuration of your APM SERVER.

```php
define('APM_APPNAME', 'app-name');
define('APM_APPVERSION', '1.0.0');
define('APM_SERVERURL', 'http://apm-server:8200');
define('APM_SECRETTOKEN', 'abcd');
define('APM_ENVIRONMENT', 'development');
define('APM_ACTIVE', true);
```

## References
* https://github.com/philkra/elastic-apm-php-agent
* https://www.elastic.co/guide/en/apm/server/current/exported-fields-system.html

## License
The Wordpress APM agent Elasticsearch plugin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
