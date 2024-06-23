<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$config['index_page'] = '';
$routes->get('/','WelcomeController::index');
$routes->get('/about', 'WelcomeController::about');
$routes->get('/contact', 'WelcomeController::contact');
$routes->get('/gallery', 'WelcomeController::gallery');
$routes->get('/menu', 'WelcomeController::menu');
$routes->get('/reservation', 'WelcomeController::reservation');
$routes->get('/event/(:num)', 'WelcomeController::event/$1');

### SECURE AREA ###
$routes->get('/admin' , 'AdminController::index');
$routes->post('/admin' , 'AdminController::index');
$routes->post('/admin/signUp', 'AdminController::signUp');
$routes->get('/admin/logout', 'AdminController::logout');

### EVENTS ###
$routes->get('/admin/events', 'EventController::index');
$routes->get('/admin/events/upload', 'EventController::upload');
$routes->post('/admin/events/save', 'EventController::save');
$routes->get('/admin/events/delete/(:num)', 'EventController::delete/$1');
$routes->get('/admin/events/edit/(:num)', 'EventController::edit/$1');
$routes->post('/admin/events/update/(:num)', 'EventController::update/$1');
$routes->get('/admin/events/view/(:num)', 'EventController::view/$1');
$routes->post('/admin/events/search', 'EventController::search');


### FOOD ###
$routes->get('/admin/food', 'FoodController::index');
$routes->get('/admin/food/upload', 'FoodController::upload');
$routes->post('/admin/food/save', 'FoodController::save');
$routes->get('/admin/food/delete/(:num)', 'FoodController::delete/$1');
$routes->get('/admin/food/edit/(:num)', 'FoodController::edit/$1');
$routes->post('/admin/food/update/(:num)', 'FoodController::update/$1');
$routes->get('/admin/food/view/(:num)', 'FoodController::view/$1');
$routes->post('/admin/food/search', 'FoodController::search');
