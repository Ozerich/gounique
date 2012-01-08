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


$route['kundenverwaltung'] = 'kundenverwaltung_controller';
$route['agenturen'] = 'kundenverwaltung_controller/agenturen';
$route['incoming'] = 'kundenverwaltung_controller/incoming';
$route['stammkunden'] = 'kundenverwaltung_controller/stammkunden';
$route['mitarbeiter'] = 'kundenverwaltung_controller/mitarbeiter';
$route['agenturen/new'] = 'kundenverwaltung_controller/new_/agenturen';
$route['incoming/new'] = 'kundenverwaltung_controller/new_/incoming';
$route['stammkunden/new'] = 'kundenverwaltung_controller/new_/stammkunden';
$route['mitarbeiter/new'] = 'kundenverwaltung_controller/new_/mitarbeiter';
$route['agenturen/(:any)'] = 'kundenverwaltung_controller/agenturen/$1';
$route['incoming/(:any)'] = 'kundenverwaltung_controller/incoming/$1';
$route['stammkunden/(:any)'] = 'kundenverwaltung_controller/stammkunden/$1';
$route['mitarbeiter/(:any)'] = 'kundenverwaltung_controller/mitarbeiter/$1';
$route['kundenverwaltung/(:any)'] = 'kundenverwaltung_controller/$1';


$route['reservierung'] = 'reservierung_controller/create';
$route['reservierung/final/(:num)'] = 'reservierung_controller/final_/$1';
$route['reservierung/(:any)'] = 'reservierung_controller/$1';


$route['settings'] = 'settings_controller';
$route['settings'] = 'settings_controller/offers';
$route['settings/(:any)'] = 'settings_controller/$1';


$route['dashboard'] = 'dashboard_controller';
$route['dashboard/(:any)'] = 'dashboard_controller/$1';



/* End of file routes.php */
/* Location: ./application/config/routes.php */