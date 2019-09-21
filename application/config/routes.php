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
$route['default_controller'] = 'front/index';
$route['404_override'] = 'Errors/_404';
$route['translate_uri_dashes'] = FALSE;

for ($i=0; $i < 5; $i++) {
    // Map admin calls to the corresponding admin controllers functions.
    $route['admin'.str_repeat('/(:any)', $i)] = 'admin'.(($i == 0) ? '' : '/$'.implode(range(1, $i), '/$'));
}

for ($i=0; $i < 5; $i++) {
    // Map front end user dashbord calls to the corresponding front controllers functions.
    $route['user_dashboard'.str_repeat('/(:any)', $i)] = 'front'.(($i == 0) ? '' : '/$'.implode(range(1, $i), '/$'));
}

for ($i=0; $i < 5; $i++) {
    // Map front end calls to the corresponding front controllers functions.
    $route['(:any)'.str_repeat('/(:any)', $i)] = 'front'.('/$'.implode(range(1, $i+1), '/$'));
}