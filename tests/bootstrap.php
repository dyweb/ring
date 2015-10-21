<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午7:03
 */
require_once(__DIR__ . '/../vendor/autoload.php');

// start a built in web server for test, thanks to http://tech.vg.no/2013/07/19/using-phps-built-in-web-server-in-your-test-suites/

// set timezone to shanghai to avoid warning
date_default_timezone_set('Asia/Shanghai');

// if constants are not defined in phpunit.xml, use default value, so we can use bootstrap as single script
if (!defined('WEB_SERVER_PORT')) {
    define('WEB_SERVER_PORT', 9876);
}
if (!defined('WEB_SERVER_DOCROOT')) {
    define('WEB_SERVER_DOCROOT', realpath(__DIR__ . '/../example/'));
}

$host = 'localhost';
$port = WEB_SERVER_PORT;
$root = WEB_SERVER_DOCROOT;
$command = sprintf('php -S %s:%d -t %s >/dev/null 2>&1 & echo $!',
    $host, $port, $root);

$output = array();
exec($command, $output);
$pid = (int)$output[0];

echo sprintf(
        '%s - Web server started on %s:%d with PID %d',
        date('r'),
        $host, $port, $pid) . PHP_EOL;

// shut down the server when exit
register_shutdown_function(function () use ($pid) {
    echo sprintf('%s - Killing process with ID %d', date('r'), $pid) . PHP_EOL;
    exec('kill ' . $pid);
});