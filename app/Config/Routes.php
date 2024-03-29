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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

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
$routes->get('/', 'Home::index');
$routes->get("micuenta", "Home::miCuenta", ['filter' => 'auth']);

$routes->get('/lang/{locale}', 'Language::index');

$routes->get('reservar/mesa', 'Home::reservarMesa', ['filter' => 'auth']);
$routes->get('reservar/habitacion/(:num)', 'Home::reservarHab/$1');
$routes->get('habitaciones', 'Home::verHabitaciones', ['filter' => 'auth']);

$routes->get('carta/(:num)', 'Platos::verCarta/$1');
$routes->post('admin/damePlatos', 'Platos::platosPorCategoria');

$routes->post('admin/subirComanda', 'Comandas::subirComanda');

$routes->post('cambiaDatosCuenta', 'Usuarios::cambiarDatos');
$routes->post('cambiarPassword', 'Usuarios::cambiarPassword');
$routes->post('admin/cambiaDatosCuenta', 'Usuarios::cambiarDatos');
$routes->post('admin/cambiarPassword', 'Usuarios::cambiarPassword');

$routes->post('doLogin', 'Login::doLogin');
$routes->get('logout', 'Login::logout');
$routes->post('doRegister', 'Register::doRegister');

$routes->post('reservar/reservarMesa', 'ReservasMesa::realizar');
$routes->post('admin/mostrarMesas', 'ReservasMesa::mostrarMesasDisponibles');
$routes->post('admin/confirmarReservaMesa', 'ReservasMesa::confirmar');
$routes->post('admin/rechazarReservaMesa', 'ReservasMesa::rechazar');
$routes->get('admin/dameMesasHoy', 'ReservasMesa::dameMesasHoy');

$routes->post('buscarHabitaciones', 'ReservasHabitacion::buscarHabitaciones');
$routes->post('reservarHab', 'ReservasHabitacion::realizar');
$routes->post('admin/confirmarReservaHab', 'ReservasHabitacion::confirmar');
$routes->post('admin/rechazarReservaHab', 'ReservasHabitacion::rechazar');

$routes->get('admin', 'Admin::index', ['filter' => 'auth']);
$routes->get('admin/micuenta', "Admin::miCuenta", ['filter' => 'auth']);
$routes->get('admin/comandas', 'Admin::comandas', ['filter' => 'auth']);
$routes->get('admin/reservas-mesa-pendientes', 'Admin::reservasMesaPendientes', ['filter' => 'auth']);
$routes->get('admin/reservas-habs-pendientes', 'Admin::reservasHabPendientes', ['filter' => 'auth']);
$routes->get('admin/reservas-mesa-confirmadas', 'Admin::reservasMesaConfirmadasHoy', ['filter' => 'auth']);
$routes->get('admin/reservas-habs-confirmadas', 'Admin::reservasHabConfirmadasHoy', ['filter' => 'auth']);

// ---- CRUD ----

$routes->get('admin/crud/reservas-mesa', 'ReservasMesa::crud', ['filter' => 'auth']);
$routes->post('admin/crud/modificar-reserva-mesa', 'ReservasMesa::update');
$routes->post('admin/crud/eliminar-reserva-mesa', 'ReservasMesa::delete');
$routes->post('admin/crud/crear-reserva-mesa', 'ReservasMesa::create');

$routes->get('admin/crud/reservas-hab', 'ReservasHabitacion::crud', ['filter' => 'auth']);
$routes->post('admin/crud/modificar-reserva-hab', 'ReservasHabitacion::update');
$routes->post('admin/crud/eliminar-reserva-hab', 'ReservasHabitacion::delete');
$routes->post('admin/crud/crear-reserva-hab', 'ReservasHabitacion::create');

$routes->get('admin/crud/comandas', 'Comandas::crud', ['filter' => 'auth']);
$routes->post('admin/crud/modificar-comanda', 'Comandas::update');
$routes->post('admin/crud/eliminar-comanda', 'Comandas::delete');
$routes->post('admin/crud/crear-comanda', 'Comandas::create');

$routes->get('admin/crud/platos', 'Platos::crud', ['filter' => 'auth']);
$routes->post('admin/crud/modificar-plato', 'Platos::update');
$routes->post('admin/crud/eliminar-plato', 'Platos::delete');
$routes->post('admin/crud/crear-plato', 'Platos::create');

$routes->get('admin/crud/usuarios', 'Usuarios::crud', ['filter' => 'auth']);
$routes->get('admin/crud/filtrar-usuarios', 'Usuarios::filtrar');
$routes->post('admin/crud/modificar-usuario', 'Usuarios::update');
$routes->post('admin/crud/eliminar-usuario', 'Usuarios::delete');
$routes->post('admin/crud/crear-usuario', 'Usuarios::create');

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