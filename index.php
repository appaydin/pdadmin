<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__ . '/app/autoload.php';

/**
 * Production Mode (prod)
 */
function prod()
{
    include_once __DIR__ . '/var/bootstrap.php.cache';

    $kernel = new AppKernel('prod', false);
    $kernel->loadClassCache();
    $kernel = new AppCache($kernel);

    // When using the HttpCache, you need to call the method in your front controller instead of relying on the configuration parameter
    //Request::enableHttpMethodParameterOverride();

    $request = Request::createFromGlobals();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
}

/**
 * Developer Mode (dev)
 */
function dev()
{
    Symfony\Component\Debug\Debug::enable();
    $kernel = new AppKernel('dev', true);

    $request = Request::createFromGlobals();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
}

/**
 * Set Environment
 */
$config = Yaml::parse(file_get_contents('app/config/settings/developer_params.yml'))['parameters'];
if ($config['developer_mode']) {
    if ($config['developer_profiler_matcher'] && !is_null($config['developer_profiler_matcher_ips'])) {
        if ($config['developer_profiler_matcher_ips'] == $_SERVER['REMOTE_ADDR']) {
            dev();
        } else {
            prod();
        }
    } else {
        dev();
    }
} else {
    prod();
}