<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/getData','MainController::getData');
$routes->match(['post', 'get'], '/login', 'MainController::login');
$routes->post('/register', 'MainController::register');
$routes->get('/fetchUserDetails', 'MainController::fetchUserDetails');
$routes->get('/getannounce', 'AdminController::getannounce');

$routes->get('/chatbot', 'MainController::index');
$routes->get('/getUser', 'MainController::getUser');
$routes->get('/getSchedule', 'MainController::getSchedule');
$routes->post('/chatbotinteraction', 'MainController::chatbotInteraction');

$routes->get('/faq', 'AdminController::index'); 
$routes->post('/create-faq', 'AdminController::createFAQ');
$routes->get('fetchFaq/(:num)', 'AdminController::fetchFaq/$1');
$routes->put('/updateFaq/(:num)', 'AdminController::updateFaq/$1');
$routes->delete( '/deleteFAQ/(:num)', 'AdminController::deleteFAQ/$1');
$routes->get('/getFAQ', 'MainController::getFAQ');
$routes->get('/faq/(:num)', 'MainController::getFAQById/$1');

$routes->match(['get', 'post'],'/create-announcement', 'AdminController::createannounce');
$routes->post('/upload-image', 'AdminController::uploadImage');

$routes->get('/fetch-announcements', 'AdminController::fetchAnnouncements');
$routes->get('/edit-announcement/(:num)', 'AdminController::editAnnouncement/$1');
$routes->post('/update-announcement/(:num)', 'AdminController::updateAnnouncement/$1');
$routes->get('/delete-announcement/(:num)', 'AdminController::deleteAnnouncement/$1');
$routes->post('/createannounce', 'AdminController::createannounce');
$routes->put('/updateannounce/(:num)', 'AdminController::updateannounce/$1');
$routes->get('/schedule', 'ReservationController::index'); // View all schedules
// $routes->get('/schedule/create', 'ReservationController::create'); // Show create form
$routes->match(['get', 'post'], '/createSchedule', 'ReservationController::create');

$routes->get('fetchSched/(:num)', 'AdminController::fetchSched/$1');
$routes->put('updateSched/(:num)', 'ReservationController::updateSched/$1');
$routes->delete( '/deleteSched/(:num)', 'ReservationController::deleteSched/$1');
$routes->post('/schedule/bookAppointment', 'ReservationController::bookAppointment');
$routes->get('/schedule/getAvailableAppointments', 'MainController::getAvailableAppointments');

