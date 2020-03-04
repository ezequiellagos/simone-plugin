<?php 

/**
* @package SimoneScraper
*/

/*
Plugin Name: Simone Scraper
Plugin URI: https://simone.upla.cl
Description: Plugin para administrar noticias de sitios externos
Version: 0.1.0
Author: Ezequiel Lagos
Author URI: https://simone.upla.cl
License: GPLv2 or later
Text Domain: simone-scraper
*/

defined('ABSPATH') or die("Bye bye");

define( 'SCRAPER_PATH', str_replace('\\', '/', plugin_dir_path( __FILE__ )) );
define( 'SCRAPER_MAIN_FILE', __FILE__ );
define( 'SCRAPER_PATH_PUBLIC', SCRAPER_PATH . 'public/' );

define( 'SCRAPER_NOMBRE', 'Scraper' );

// Activación y desactivación del plugin
include ( SCRAPER_PATH . '/includes/activation.php');

// Menu de opciones barra lateral
include ( SCRAPER_PATH . '/includes/options.php');

// Funciones de plugin
include ( SCRAPER_PATH . '/includes/functions.php');





 ?>
