<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->group('', ['filter' => 'authCheck'], function($routes){
    $routes->get('/Home', 'Home::index');
    $routes->get('/Moderator', 'Moderator::index');
    $routes->get('/Moderator/update/(:num)', 'Moderator::update');
    $routes->get('/Moderator/delete', 'Moderator::delete');
    $routes->get('/Moderator/delete/(:num)', 'Moderator::delete_user');
});

$routes->group('', ['filter' => 'authAlreadyLogged'], function($routes){
    $routes->get('/Authenticate/register', 'Authenticate::register');
    $routes->get('/Authenticate', 'Authenticate::index');
});

$routes->group('', ['filter' => 'adminCheck'], function($routes){
    $routes->get('/Moderator', 'Moderator::index');
    $routes->get('/Moderator/update/(:num)', 'Moderator::update');
    $routes->get('/Moderator/delete', 'Moderator::delete');
    $routes->get('/Moderator/delete/(:num)', 'Moderator::delete_user');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
