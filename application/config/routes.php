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

$route['kundenverwaltung'] = 'kundenverwaltung_controller';

$route['agenturen'] = 'kundenverwaltung_controller/agenturen';
$route['incoming'] = 'kundenverwaltung_controller/incoming';
$route['stammkunden'] = 'kundenverwaltung_controller/stammkunden';
$route['mitarbeiter'] = 'kundenverwaltung_controller/mitarbeiter';



$route['auth'] = 'auth_controller';

$route['login'] = 'auth_controller/login';
$route['logout'] = 'auth_controller/logout';

$route['settings'] = 'settings_controller';
$route['settings'] = 'settings_controller/offers';
$route['settings/(:any)'] = 'settings_controller/$1';

$route['formular'] = 'formular_controller';
$route['formular/final/(:num)'] = 'formular_controller/final_/$1';
$route['formular/(:num)'] = 'formular_controller/final_/$1';
$route['formular/(:any)'] = 'formular_controller/$1';

$route['dashboard'] = 'dashBoard_controller';
$route['dashboard/(:any)'] = 'dashBoard_controller/$1';


$route['agency'] = 'dashboard';
$route['agency/(:num)'] = 'agency_Controller/view/$1';
$route['agency/(:any)'] = 'agency_Controller/$1';



/* End of file routes.php */
/* Location: ./application/config/routes.php */