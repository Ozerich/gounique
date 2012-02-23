<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'dashboard_controller';
$route['404_override'] = '';


$route['auth'] = 'auth_controller';
$route['login'] = 'auth_controller/login';
$route['logout'] = 'auth_controller/logout';


$route['kundenverwaltung'] = 'kundenverwaltung_controller/agenturen';
$route['agenturen'] = 'kundenverwaltung_controller/agenturen';
$route['incoming'] = 'kundenverwaltung_controller/incoming';
$route['stammkunden'] = 'kundenverwaltung_controller/stammkunden';
$route['ketten'] = 'kundenverwaltung_controller/ketten';
$route['provisionierung'] = 'kundenverwaltung_controller/provisionierung';

$route['agenturen/new'] = 'kundenverwaltung_controller/new_/agenturen';
$route['incoming/new'] = 'kundenverwaltung_controller/new_/incoming';
$route['stammkunden/new'] = 'kundenverwaltung_controller/new_/stammkunden';
$route['ketten/new'] = 'kundenverwaltung_controller/new_/ketten';
$route['provisionierung/new'] = 'kundenverwaltung_controller/new_/provisionierung';

$route['agenturen/delete/(:num)'] = 'kundenverwaltung_controller/delete/agenturen/$1';
$route['incoming/delete/(:num)'] = 'kundenverwaltung_controller/delete/incoming/$1';
$route['stammkunden/delete/(:num)'] = 'kundenverwaltung_controller/delete/stammkunden/$1';
$route['ketten/delete/(:num)'] = 'kundenverwaltung_controller/delete/ketten/$1';
$route['provisionierung/delete/(:num)'] = 'kundenverwaltung_controller/delete/provisionierung/$1';

$route['agenturen/(:any)'] = 'kundenverwaltung_controller/agenturen/$1';
$route['incoming/(:any)'] = 'kundenverwaltung_controller/incoming/$1';
$route['stammkunden/(:any)'] = 'kundenverwaltung_controller/stammkunden/$1';
$route['ketten/(:num)'] = 'kundenverwaltung_controller/ketten/$1';
$route['provisionierung/(:num)'] = 'kundenverwaltung_controller/provisionierung/$1';
$route['kundenverwaltung/(:any)'] = 'kundenverwaltung_controller/$1';


$route['reservierung'] = 'reservierung_controller';
$route['reservierung/final/(:num)'] = 'reservierung_controller/final_/$1';
$route['reservierung/(:any)'] = 'reservierung_controller/$1';

$route['statistik'] = 'statistik_controller';
$route['statistik/(:any)'] = 'statistik_controller/$1';

$route['dashboard'] = 'dashboard_controller';
$route['dashboard/(:any)'] = 'dashboard_controller/$1';

$route['settings/offers'] = 'settings_controller/offers';
$route['settings/(:any)'] = 'settings_controller/$1';

$route['product/hotel'] = 'producthotel_controller';
$route['product/hotel/(:any)'] = 'producthotel_controller/$1';

$route['product/rundreise'] = 'productrundreise_controller';
$route['product/rundreise/(:any)'] = 'productrundreise_controller/$1';

$route['product'] = 'product_controller';
$route['product/(:any)'] = 'product_controller/$1';

$route['control'] = 'control_controller';
$route['control/(:any)'] = 'control_controller/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */