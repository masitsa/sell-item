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
$route['default_controller'] = 'advertiser';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

/**
 * Infomoby routes
 */
$route['infomoby/register-business'] = "infomoby/registration/register_business";
$route['infomoby/getfavlistings'] = "infomoby/favouritelistings/favorite_listings";
$route['infomoby/getcompanyLength'] = "infomoby/favouritelistings/companyLength";
$route['infomoby/sendactioncard'] = "infomoby/favouritelistings/send_actioncard";
$route['searched_customers'] = "infomoby/registration/searched_customers";

/**
 * Royal Media Service routes
 */
$route['royalmedia/save-item'] = "royalmedia/registration/register_services";
$route['royalmedia/search'] = "royalmedia/registration/services_search";
$route['royalmedia/items'] = "royalmedia/registration/items_search";
$route['royalmedia/categories'] = "royalmedia/categories/categories";
$route['royalmedia/category-items'] = "royalmedia/categories/category_items";
$route['royalmedia/purchase-items'] = "royalmedia/registration/purchase_items";
$route['royalmedia/units'] = "royalmedia/categories/units";
$route['royalmedia/allitems'] = "royalmedia/categories/items";

/**
 * Mawingu routes
 */
$route['mawingu/generate-bucket-names'] = "mawingu/merchant_location/generate_bucket_names";
$route['mawingu/remove-throughput-spaces'] = "mawingu/merchant_location/remove_throughput_spaces";
$route['mawingu/update-bucket'] = "mawingu/merchant_location/update_data_throughput_with_location";
$route['mawingu/heatmap'] = "mawingu/merchant_location/populate_heat_map";
$route['mawingu/customers'] = "mawingu/telesales/get_customers";
$route['mpesa/searched_customers'] = "mawingu/telesales/searched_customers";

/**
 * Safaricom routes
 */
$route['safaricom/get-regions'] = "safaricom/sso/get_regions";
$route['safaricom/save-sso'] = "safaricom/sso/save_sso";
$route['safaricom/send-report'] = "safaricom/sso/get_region";

/**
 * LaikipiaSchools routes
 */
$route['laikipiaschools/save'] = "laikipiaschools/save/savetodb";
$route['laikipiaschools/schools'] = "laikipiaschools/fetch/getschools";
$route['laikipiaschools/view'] = "laikipiaschools/getSchools/allSchools";
// $route['default_controller'] = 'pages/view';
// $route['(:any)'] = 'pages/view/$1';

/**
 * Well Told Stories
 */
$route['wts/sendsms/(:any)'] = "wts/contact/sendsms/$1";

/**
 * KPC
 */
$route['kpc/save-incident'] = "kpc/incidents/save_incident";
$route['kpc/region-subscribers'] = "kpc/incidents/region_subscribers";
$route['kpc/get-incident'] = "kpc/incidents/get_incident";
$route['kpc/sos-incident'] = "kpc/erts/save_ert";
$route['kpc/get-ert'] = "kpc/erts/get_ert";
$route['kpc/get-sos'] = "kpc/erts/get_sos";
$route['kpc/save-sos'] = "kpc/erts/save_sos";

/**
 * M-kopa
 */
$route['mkopa/save'] = "m-kopa/mkopa/save_checkin";

/**
 * AppFactory
 */
$route['appfactory/save-progress'] = "appfactory/progress/save_progress";

/**
 * EthiopianAirlines
 */
$route['ethiopianairlines/viewfilecontents'] = "ethiopiaairlines/filecontents/getSelectedFile";
$route['ethiopianairlines/uploadfiles'] = "ethiopiaairlines/filecontents/index";
$route['ethiopianairlines/getuploadfiles'] = "ethiopiaairlines/filecontents/get_saved_files";
