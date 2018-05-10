<?php
/*
Plugin Name: MicroFramework
Plugin URI:
Description:
Version: 0.1.0
Author: Ivan Barić
Author URI:
Text Domain: micro-framework
Domain Path: /languages
*/

if(!defined('ABSPATH')) exit;

if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ){
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}



//Set MicroConfig
\Micro\Config::set(__FILE__, __DIR__);


//Load Include Folder, Styles and Scripts, Translation, Activation, Uninstall
\Micro\MainController::load();