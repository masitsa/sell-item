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







$route['default_controller'] = 'martin';



$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

/**
 * samuel routes
 */
$route['samuel/get-brands-models'] = "samuel/brands/get_brands_and_models";
$route['samuel/save-registration'] = "samuel/registrations/create_registrations";
$route['samuel/save-car'] = "samuel/cars/create_cars";
$route['samuel/get-posted-cars'] = "samuel/brands/get_posted_cars";
$route['samuel/save-order'] = "samuel/orders/create_orders";


/**
 * Alvaro/grace routes
 */
$route['alvaro/get-brands'] = "alvaro/brands/get_brands";
$route['alvaro/save-checkin'] = "alvaro/checkins/create_checkin";

/**
 * Philip routes
 */
$route['philip/get-brands-models'] = "philip/brands/retrieve_brands_and_models";
$route['philip/get-cars'] = "philip/brands/retrieve_cars";
$route['philip/save-seller'] = "philip/cars/create_seller";

/**
 * cecilia routes
 */
$route['cecilia/get-brands'] = "cecilia/brands/get_brands";
//$route['cecilia/get-modelandname'] = "cecilia/brands/getmodelandname";
$route['cecilia/create-car'] = "cecilia/cars/create_car";
$route['cecilia/get-cars'] = "cecilia/brands/getcars";
$route['cecilia/create-buyer'] = "cecilia/buyers/create_buyer";

$route['sarafina1/create_seller_action_card'] = "sarafina1/action_cards/create_seller_action_card";
$route['sarafina1/get_brands'] = "sarafina1/brands/get_brands";
$route['sarafina1/retrieveSoldCars'] = "sarafina1/action_cards/retrieveSoldCars";

/**
 * Martin routes
 */
$route['martin/get-brands'] = "martin/brands/get_brands";
$route['martin/brands-models'] = "martin/brands/get_brands_and_models";
$route['martin/get-cars'] = "martin/brands/get_posted_cars";
$route['martin/save-card'] = "martin/cars/create_card";

//grace routes
$route['grace/get-brands'] = "grace/brands/get_brands";
$route['grace/create_checkin'] = "grace/sender_details/create_checkin";
$route['grace/Seller_Details'] = "grace/brands/Seller_Details";

/**
 * Moses routes
 */
$route['moses/get-brands'] = "moses/brands/get_brands";
$route['moses/create-transaction'] = "moses/transactions/create_transaction";
$route['moses/create-car'] = "moses/cars/create_car";




// $route['philip/get-brands'] = "philip/brands/get_brands";
$route['patricia/get-brands'] = "patricia/brands/get_brands";
$route['patricia/create_sell'] = "patricia/sells/create_sell";
$route['patricia/retrieveSoldCars'] = "patricia/brands/retrieveSoldCars";
//$route['patricia/access'] = "patricia/access/getAccess";
