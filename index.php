<?php
////////////////////////////////////////////////////////////////////////////////
//                     ___  ____  _____ _____ ____  _                         //
//                    / ___||  _ \| ____| ____|  _ \( )_   _ _ __             //
//                    \___ \| |_) |  _| |  _| | | | |/| | | | '_ \            //
//                    ___) |  __/| |___| |___| |_| | | |_| | |_) |            //
//                   |____/|_|   |_____|_____|____/   \__,_| .__/             //
//                                                        |_|                 //
////////////////////////////////////////////////////////////////////////////////
/** Autoload de Composer*/
if (file_exists('vendor/autoload.php')) {
    require 'vendor/autoload.php';
} else {
    echo "<h1>Please install via composer.json</h1>";
    echo "<p>Install Composer instructions: <a href='https://getcomposer.org/doc/00-intro.md#globally'>https://getcomposer.org/doc/00-intro.md#globally</a></p>";
    echo "<p>Once composer is installed navigate to the working directory in your terminal/command promt and enter 'composer install'</p>";
    exit;
}
if (!is_readable('Application/Core/Configuration.php')) {
    die('No Config.php found, configure and rename Config.example.php to Config.php in app/Core.');
}
/*
 *---------------------------------------------------------------
 *  ENVIRONMENTS
 *---------------------------------------------------------------
 *
 * Plusieurs choix d'environnement
 *
 * Usage:
 *
 *     developpement
 *     production
 *
 *
 *
 */
    define('ENVIRONMENT', 'developpement');
/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but production will hide them.
 */
if (defined('ENVIRONMENT')) {
    switch (ENVIRONMENT) {
        case 'developpement':
            error_reporting(E_ALL);
            break;
        case 'production':
            error_reporting(0);
            break;
        default:
            exit('L\'environnement de developpement n\'est pas correctement configuré');
    }
}
/**  config */


if(!file_exists("Application/Core/install.php")){

  new Core\Configuration();
  require 'Application/Core/routes.php';

} else {
  require 'Application/Core/install.php';
}

 ?>
