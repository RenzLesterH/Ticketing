<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'appointment';
$route['login/validate'] = 'appointment/process_login';
$route['logout'] = 'appointment/logout';
$route['dashboard'] = 'dashboard';
$route['add_transaction/validate'] = 'dashboard/add_transaction_process';
$route['view_client_transaction/(:any)'] = 'dashboard/view_client_transaction/$1';
$route['view_transaction/(:any)'] = 'dashboard/view_transaction/$1';
$route['load/(:any)'] = 'dashboard/load_partial_pages/$1';
$route['update_transaction/validate'] = 'dashboard/update_transaction_process';
$route['client_transaction/validate'] = 'dashboard/update_client_transaction_progress';
$route['view_action_form/(:any)'] = 'dashboard/view_action_form/$1';
$route['print_transaction/(:any)'] = 'dashboard/print_transaction/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE; 
