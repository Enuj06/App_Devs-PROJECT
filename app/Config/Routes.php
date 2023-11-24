<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->match(['post', 'get'], '/login', 'MainController::login');
$routes->post('/chatbotinteraction', 'MainController::chatbotInteraction');