<?php


$raw_uri_path = ltrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$uri_path = preg_replace('{/$}', '', $raw_uri_path);

$landing_script = INDEX_SCRIPT;

$index_script = (isset($landing_script) && $landing_script != '') ? '/'.$landing_script : '';

$specified_host_uri_path = parse_url(HOST_URL.$index_script, PHP_URL_PATH);

define('BASE_URL', $specified_host_uri_path);

$matching_uri_string = str_replace($specified_host_uri_path, '', $uri_path);

$uri_segments = explode('/', $matching_uri_string);

$class_name = (isset($uri_segments[1])&&  '' !== $uri_segments[1]) ? $uri_segments[1] : DEFAULT_CONTROLLER;

$method_name = isset($uri_segments[2]) ? $uri_segments[2] : null;

$param1 = isset($uri_segments[3]) ? $uri_segments[3] : null;

$param2 = isset($uri_segments[4]) ? $uri_segments[4] : null;


if ($class_name !== null)
{
    $class = ucfirst($class_name) . 'Controller';
}
else
{
    $class = DEFAULT_CONTROLLER . 'Controller';

    $method_name = isset($uri_segments[1]) ? $uri_segments[1] : null;

    $param1 = isset($uri_segments[2]) ? $uri_segments[2] : null;

    $param2 = isset($uri_segments[3]) ? $uri_segments[3] : null;
}