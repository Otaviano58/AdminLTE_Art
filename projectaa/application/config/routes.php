<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['project/show-all'] = "project/show_all";
$route['project'] = "project/index";
$route['project/create'] = "project/create";
$route['project/store']['post'] = "project/store";
$route['project/edit/(:num)'] = "project/edit/$1";
$route['project/update/(:num)']['put'] = "project/update/$1";
$route['project/delete/(:num)']['delete'] = "project/delete/$1";


$route['default_controller'] = 'Project';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
