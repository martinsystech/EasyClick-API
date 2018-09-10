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
| example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
| https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
| $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
| $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
| $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|   my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;


$route['Subscriptores']['get'] = 'Subscriptores/index';
$route['Subscriptores/(:num)']['get'] = 'Subscriptores/find/$1';
$route['Subscriptores']['post'] = 'Subscriptores/index';
$route['Subscriptores/(:num)']['put'] = 'Subscriptores/index/$1';
$route['Subscriptores/(:num)']['delete'] = 'Subscriptores/index/$1';

$route['Login/(:any)']['get'] = 'Login/find/$1';

$route['Social']['get'] = 'Social/index';
$route['Social/(:any)']['get'] = 'Social/find/$1';

$route['Directorio/(:any)']['get'] = 'Directorio/find/$1';

$route['Novedades/(:any)']['get'] = 'Novedades/find/$1';

$route['Inicio/(:any)']['get'] = 'Inicio/find/$1';

$route['Detalles/(:any)']['get'] = 'Detalles/find/$1';

$route['DetallesNovedad/(:any)']['get'] = 'DetallesNovedad/find/$1';

$route['Comentarios/(:any)']['get'] = 'Comentarios/find/$1';
$route['Comentarios']['post'] = 'Comentarios/index';
$route['Comentarios/(:num)']['delete'] = 'Comentarios/index/$1';


$route['Vistas/(:any)']['get'] = 'Vistas/find/$1';
$route['Vistas']['post'] = 'Vistas/index';

$route['Estrellas/(:any)']['get'] = 'Estrellas/find/$1';
$route['Estrellas']['post'] = 'Estrellas/index';

$route['Agenda/(:num)']['get'] = 'Agenda/find/$1';
$route['Agenda']['post'] = 'Agenda/index';
$route['Agenda/(:num)']['put'] = 'Agenda/index/$1';
$route['Agenda/(:num)']['delete'] = 'Agenda/index/$1';

$route['Ubicacion']['get'] = 'Ubicacion/index';
$route['Ubicacion/(:any)']['get'] = 'Ubicacion/find/$1';

$route['Giros']['get'] = 'Giros/index';  
$route['Giros/(:any)']['get'] = 'Giros/find/$1';

$route['EventosSubscriptor/(:num)']['get'] = 'EventosSubscriptor/find/$1';

$route['OfertasSubscriptor/(:num)']['get'] = 'OfertasSubscriptor/find/$1';

$route['ValidarAgenda/(:any)']['get'] = 'ValidarAgenda/find/$1';

$route['AgendaNovedades']['post'] = 'AgendaNovedades/index';

$route['RecuperarPassword/(:any)']['get'] = 'RecuperarPassword/find/$1';
/*
| -------------------------------------------------------------------------
| Sample REST API Routes
| -------------------------------------------------------------------------
*/
$route['api/example/users/(:num)'] = 'api/example/users/id/$1'; // Example 4
$route['api/example/users/(:num)(\.)([a-zA-Z0-9_-]+)(.*)'] = 'api/example/users/id/$1/format/$3$4'; // Example 8
