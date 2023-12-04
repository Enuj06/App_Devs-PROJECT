<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/getData','MainController::getData');
$routes->match(['post', 'get'], '/login', 'MainController::login');
$routes->post('/register', 'MainController::register');

$routes->get('/chatbot', 'MainController::index');
$routes->post('/chatbotinteraction', 'MainController::chatbotInteraction');