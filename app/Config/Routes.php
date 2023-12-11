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

$routes->get('/faq', 'AdminController::index'); 
$routes->post('/create-faq', 'AdminController::createFAQ');
$routes->get('/edit-faq/(:num)', 'AdminController::editFAQ/$1');
$routes->post('/update-faq/(:num)', 'AdminController::updateFAQ/$1');
$routes->get('/delete-faq/(:num)', 'AdminController::deleteFAQ/$1');

$routes->post('/create-announcement', 'AdminController::createannounce');
$routes->post('/upload-image', 'AdminController::uploadImage');
$routes->get('/fetch-announcements', 'AdminController::fetchAnnouncements');
$routes->get('/edit-announcement/(:num)', 'AdminController::editAnnouncement/$1');
$routes->post('/update-announcement/(:num)', 'AdminController::updateAnnouncement/$1');
$routes->get('/delete-announcement/(:num)', 'AdminController::deleteAnnouncement/$1');

$routes->get('/schedule', 'ReservationController::index'); // View all schedules
$routes->get('/schedule/create', 'ReservationController::create'); // Show create form
$routes->post('/schedule/create', 'ReservationController::create'); // Create new schedule
$routes->get('/edit/(:num)', 'ReservationController::edit/$1'); // Show edit form for a schedule
$routes->post('/schedule/update/(:num)', 'ReservationController::update/$1');
$routes->get('/delete/(:num)', 'ReservationController::delete/$1'); // Delete schedule
$routes->post('/schedule/bookAppointment', 'ReservationController::bookAppointment');