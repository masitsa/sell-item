<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */

$route['default_controller'] = 'sarafina';

$route['default_controller'] = 'martin';

$route['samuel/get-brands'] = "samuel/brands/get_brands";
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

/**
 * Alvaro/grace routes
 */
$route['alvaro/get-brands'] = "alvaro/brands/get_brands";

$route['philip/get-brands-models'] = "philip/brands/retrieve_brands_and_models";
//cecilia routes
$route['cecilia/get-brands'] = "cecilia/brands/get_brands";
$route['cecilia/create-seller'] = "cecilia/brands/create_seller";

$route['sarafina/get-brands'] = "sarafina/brands/get_brands";

$route['martin/get-brands'] = "martin/brands/get_brands";


$route['grace/get-brands'] = "grace/brands/get_brands";


/**
 * Moses routes
 */
$route['moses/get-brands'] = "moses/brands/get_brands";

$route['philip/get-brands'] = "philip/brands/get_brands";
$route['patricia/get-brands'] = "patricia/brands/get_brands";
