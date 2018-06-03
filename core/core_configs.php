<?php

include APP_PATH . "/app/configs.php";

define('DEFAULT_CONTROLLER', $config['default_controller']);

define('HOST_URL', $config['host_url']);

define('INDEX_SCRIPT', $config['index_script']);

define('DEBUG', $config['debug']);


define('HOST', $config['database_host']);

define('DATABASE', $config['database_name']);

define('USERNAME', $config['database_username']);

define('PASSWORD', $config['database_password']);

define('PORT', $config['database_port']);


define('MAIL_HOST', isset($config['mail_host']) ? $config['mail_host'] : null );

define('MAIL_USERNAME', isset($config['mail_username']) ? $config['mail_username'] : null);

define('MAIL_PASSWORD', isset($config['mail_password']) ? $config['mail_password'] : null);

define('MAIL_ENCRYPTION_TYPE', isset($config['mail_encryption']) ? $config['mail_encryption'] : null);

define('MAIL_PORT', isset($config['mail_port']) ? $config['mail_port'] : null);
