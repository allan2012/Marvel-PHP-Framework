<?php

/*
 * -------------------------
 * AUTOLOAD ALL CONTROLLERS
 * -------------------------
 */
function controller_autoload($class_name)
{
    if (is_file(APP_PATH . '/app/Controllers/' . $class_name . '.php')) 
    {
        include APP_PATH . '/app/Controllers/' . $class_name . '.php';
    }
}

spl_autoload_register("controller_autoload");



/*
 * -------------------
 * AUTOLOAD ALL MODELS
 * -------------------
 */
function models_autoload($class_name)
{
    if (is_file(__DIR__ . '/App/Models/' . $class_name . '.php')) 
    {
        require_once __DIR__ . '/App/Models/' . $class_name . '.php';
    }
}

spl_autoload_register("models_autoload");



/*
 * ------------------
 * AUTOLOAD ALL VIEWS
 * ------------------
 */
function views_autoload($class_name)
{
    if (is_file(__DIR__ . '/App/Views/' . $class_name . '.php')) 
    {
        require_once __DIR__ . '/App/Views/' . $class_name . '.php';
    }
}

spl_autoload_register("views_autoload");



/*
 * -------------------------------
 * AUTOLOAD FRAMEWORK VENDOR FILES
 * -------------------------------
 */
function vendor_autoload($class_name)
{
    require_once __DIR__ . '/vendor/autoload.php';
}

spl_autoload_register("vendor_autoload");



/*
 * -----------------------------
 * AUTOLOAD FRAMEWORK CORE FILES
 * -----------------------------
 */
function core_autoload($class_name)
{
    if (is_file(__DIR__ . '/' . $class_name . '.php')) 
    {
        require_once __DIR__ . '/' . $class_name . '.php';
    }
}


spl_autoload_register("core_autoload");

$method = ucfirst($method_name);

$object = new $class();


if ($method_name === null) {
    $object->index();
}
else
{
    if ($param1 != null && $param2 != null)
    {
        $object->$method_name($param1, $param2);
    }
    elseif ($param1 != null) {
        $object->$method_name($param1);
    } else {
        $object->$method_name();
    }
}