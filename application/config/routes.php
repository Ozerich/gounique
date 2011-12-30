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

$route['default_controller'] = 'Dashboard_Controller';
$route['404_override'] = '';

$route['auth'] = 'Auth_Controller';

$route['login'] = 'Auth_Controller/login';
$route['logout'] = 'Auth_Controller/logout';

$route['settings'] = 'Settings_Controller';
$route['settings'] = 'Settings_Controller/offers';
$route['settings/(:any)'] = 'Settings_Controller/$1';

$route['formular'] = 'Formular_Controller';
$route['formular/final/(:num)'] = 'Formular_Controller/final_/$1';
$route['formular/(:num)'] = 'Formular_Controller/final_/$1';
$route['formular/(:any)'] = 'Formular_Controller/$1';

$route['dashboard'] = 'DashBoard_Controller';
$route['dashboard/(:any)'] = 'DashBoard_Controller/$1';


$route['agency'] = 'Dashboard';
$route['agency/(:num)'] = 'Agency_Controller/view/$1';
$route['agency/(:any)'] = 'Agency_Controller/$1';



/* End of file routes.php */
/* Location: ./application/config/routes.php */