 <?php

 define('APP_PATH', __DIR__);
 include __DIR__ . '/core/core_configs.php';

 if($config['debug'] == true){
     ini_set( "display_errors", "1" );
     error_reporting( E_ALL & ~E_NOTICE );
 } else {
     error_reporting( 0 );
 }
 
 include __DIR__ . '/core/url_resolver.php';
 include __DIR__ . '/core/autoload.php';


