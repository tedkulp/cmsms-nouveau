<?php

use \silk\action\Route;

//Automatically add some component routes -- see docs for details
//Route::build_default_component_routes();

Route::register_route("/admin/:controller/:action/:id", array("component" => 'admin'));
Route::register_route("/admin/:controller/:action", array("id" => '', "component" => 'admin'));
Route::register_route("/admin/:controller", array("id" => '', 'action' => 'index', "component" => 'admin'));
Route::register_route("/admin", array("id" => '', 'action' => 'index', "component" => 'admin', 'controller' => 'admin'));

//Catch-all goes here
Route::register_route_callback("*", array("CmsRoute", "run"), array());

?>