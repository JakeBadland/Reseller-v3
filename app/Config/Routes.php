<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Index');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
//$routes->get('/', 'Home::index');

$routes->get('/', 'Index::index');
$routes->get('/(:num)', 'Index::index/$1');
$routes->get('/viber/(:num)/(:num)', 'Index::viber/$1/$2');
$routes->post('/change-status', 'Index::changeOrderStatus');


$routes->get('/test', 'Index::test');

$routes->get('/login', 'Index::login');
$routes->post('/login', 'Index::login');
$routes->get('/logout', 'Index::logout');

//index
$routes->get('/dna', 'Dna\Users::index');

//users group
$routes->get('/dna/users', 'Dna\Users::index');
$routes->post('/dna/addUser', 'Dna\Users::addUser');
$routes->get('/dna/editUser/(:num)', 'Dna\Users::editUser/$1');
$routes->post('/dna/editUser', 'Dna\Users::editUser');
$routes->post('/dna/deleteUser', 'Dna\Users::deleteUser');

//cards group
$routes->get('/dna/cards', 'Dna\Cards::index');
$routes->post('/dna/cards/add', 'Dna\Cards::addCard');
$routes->get('/dna/cards/edit/(:num)', 'Dna\Cards::editCard/$1');
$routes->post('/dna/editCard', 'Dna\Cards::editCard');
$routes->post('/dna/cards/delete', 'Dna\Cards::deleteCard');

//shops group
$routes->get('/dna/shops', 'Dna\Shops::index');
$routes->post('/dna/shops/add', 'Dna\Shops::addShop');
$routes->get('/dna/shops/edit/(:num)', 'Dna\Shops::editShop/$1');
$routes->post('/dna/editShop', 'Dna\Shops::editShop');
$routes->post('/dna/shops/delete', 'Dna\Shops::deleteShop');

//rules group
$routes->get('/dna/rules', 'Dna\Rules::index');
$routes->post('/dna/rules/add', 'Dna\Rules::addRule');
$routes->get('/dna/rules/edit/(:num)', 'Dna\Rules::editRule/$1');
$routes->post('/dna/rules/edit', 'Dna\Rules::editRule');
$routes->post('/dna/rules/delete', 'Dna\Rules::deleteRule');

//templates group
$routes->get('/dna/templates', 'Dna\Templates::index');
$routes->get('/dna/templates/edit/(:num)', 'Dna\Templates::editTemplate/$1');
$routes->post('/dna/templates/edit', 'Dna\Templates::editTemplate');

//CRON group
$routes->get('/cron/c2min', 'Cron::c2min');

$routes->cli('/cron/c2min', 'Cron::c2min');
$routes->cli('/', 'Cron::index');

$routes->get('/dna/products', 'Dna\Products::index');


//GAME section
$routes->get('/game', 'Game\Game::index');
$routes->get('/game/login', 'Game\Game::login');
$routes->post('/game/login', 'Game\Auth::login');

$routes->post('/game/save-user-loc', 'Game\Game::saveUserLoc');



//$routes->get('/dna/test', 'Dna\Rules::index');

/*
$routes->post('/dna/rules/add', 'Dna::addRule');
$routes->post('/dna/rules/delete', 'Dna::deleteRule');
$routes->post('/dna/rules/update', 'Dna::updateRule');
*/

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
