<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/main', 'MainController::index');
$routes->get('/search', 'MainController::search');
$routes->post('/songupload', 'MainController::songupload');
$routes->post('/makeplaylist', 'MainController::makeplaylist');
$routes->get('/delplaylist/(:num)', 'MainController::delplaylist/$1');
$routes->get('/selplaylist/(:any)', 'MainController::selplaylist/$1');
$routes->get('/addmusictoplaylist/(:num)', 'MainController::addmusictoplaylist/$1');
$routes->get('/removemusicfromplaylist/(:num)', 'MainController::removemusicfromplaylist/$1');