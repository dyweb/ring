<?php
/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/21
 * Time: 下午7:03
 */
require_once(__DIR__ . '/../vendor/autoload.php');

// start a built in web server for test, thanks to http://tech.vg.no/2013/07/19/using-phps-built-in-web-server-in-your-test-suites/

$host = 'localhost';
$port = 9876;
$root = 'tests';
$command = sprintf('php -S %s:%d %s >/dev/null 2>&1 & echo $!',
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