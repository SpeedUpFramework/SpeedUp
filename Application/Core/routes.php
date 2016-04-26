<?php
/**
 * Routes - all standard routes are defined here.
 *
 * @author David Carr - dave@daveismyname.com
 *
 * @version 2.2
 * @date updated Sept 19, 2015
 */

/** Create alias for Router. */
use Core\Router;


/* Define routes. */
Router::any('', 'Controllers\Welcome@indexAction');
Router::any('Connexion', 'Controllers\Account@login');
Router::any('Deconnexion', 'Controllers\Account@logout');
Router::any('Inscription', 'Controllers\Account@register');
Router::any('photo', 'Controllers\Photo@index');
Router::any('admin', 'Controllers\Admin@index');
/** End default routes */



/* If no route found. */
Router::error('Core\Error@index');

/* Turn on old style routing. */
Router::$fallback = false;

/* Execute matched routes. */
Router::dispatch();
