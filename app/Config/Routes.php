<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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
$routes->group('', ['filter' => 'beforeLogin'], function ($routes) {
	$routes->get('/auth', 'Auth::index');
});

$routes->group('', ['filter' => 'afterLogin'], function ($routes) {
	$routes->get('/', 'Home::index');
	$routes->get('sarpras/ruang', 'Ruang::index');

	$routes->get('api/(:any)', 'Api::$1');

	$routes->get('/', 'Home::index');
	$routes->get('sarpras/ruang', 'Ruang::index');

	$routes->get('pengumuman', 'Pengumuman::index');
	$routes->get('pengumuman/(:any)', 'Pengumuman::$1');

	$routes->get('sp', 'SP::index');
	$routes->get('sp/(:any)', 'SP::$1');

	$routes->get('gtk', 'Gtk::index');
	$routes->get('gtk/(:any)', 'Gtk::$1');

	$routes->get('pd', 'Pd::index');
	$routes->get('pd/(:any)', 'Pd::$1');

	$routes->get('rombel', 'Rombel::index');
	$routes->get('rombel/(:any)', 'Rombel::$1');

	$routes->get('mapel', 'Mapel::index');
	$routes->get('mapel/(:any)', 'Mapel::$1');

	$routes->get('banksoal', 'Banksoal::index');
	$routes->get('banksoal/viewdata', 'Banksoal::viewdata');
	$routes->get('banksoal/save', 'Banksoal::save');
	$routes->get('banksoal/edit/(:any)', 'Banksoal::edit/$1');
	$routes->get('banksoal/delete/(:any)', 'Banksoal::delete/$1');

	$routes->group('banksoal', function ($routes) {
		$routes->add('question/(:segment)', 'Soal::index/$1');
		$routes->add('question/(:segment)/1/(:segment)', 'Soal::pg/$1/$2/$3');
		$routes->add('question/save/(:segment)/1/(:segment)', 'Soal::save/$1/1/$3');
		$routes->add('question/deletesoal/(:any)', 'Soal::deletesoal/$1');
		$routes->add('question/deleteall/(:segment)', 'Soal::deleteall/$1');
		$routes->add('question/(:segment)/2/(:segment)', 'Soalessai::essay/$1/$2/$3');
		$routes->add('question/save/(:segment)/2/(:segment)', 'Soalessai::save/$1/2/$3');

		$routes->add('importsoal/(:segment)', 'ImportSoal::index/$1');
		$routes->add('importsoal/(:segment)/save', 'ImportSoal::import/$1');
	});

	$routes->get('jadwal', 'Jadwal::index');
	$routes->get('jadwal/(:any)', 'Jadwal::$1');

	$routes->get('statuspeserta', 'Statuspeserta::index');
	$routes->get('statuspeserta/(:any)', 'Statuspeserta::$1');

	$routes->get('token', 'Token::index');
	$routes->get('token/(:any)', 'Token::$1');

	$routes->get('resetlogin', 'Resetlogin::index');
	$routes->get('resetlogin/(:any)', 'Resetlogin::$1');

	$routes->get('kartuujian', 'Kartuujian::index');
	$routes->get('kartuujian/(:any)', 'Kartuujian::$1');
});

$routes->group('admin', ['filter' => 'afterLogin'], function ($routes) {
	$routes->get('api/(:any)', 'Api::$1');

	$routes->get('/', 'Home::index');

	$routes->get('sarpras/ruang', 'Ruang::index');

	$routes->get('pengumuman', 'Pengumuman::index');
	$routes->get('pengumuman/(:any)', 'Pengumuman::$1');

	$routes->get('sp', 'SP::index');
	$routes->get('sp/(:any)', 'SP::$1');

	$routes->get('gtk', 'Gtk::index');
	$routes->get('gtk/(:any)', 'Gtk::$1');

	$routes->get('pd', 'Pd::index');
	$routes->get('pd/(:any)', 'Pd::$1');

	$routes->get('rombel', 'Rombel::index');
	$routes->get('rombel/(:any)', 'Rombel::$1');

	$routes->get('mapel', 'Mapel::index');
	$routes->get('mapel/(:any)', 'Mapel::$1');

	$routes->get('banksoal', 'Banksoal::index');
	$routes->get('banksoal/(:any)', 'Banksoal::$1');
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
