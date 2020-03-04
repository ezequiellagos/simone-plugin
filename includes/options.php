<?php defined('ABSPATH') or die("Bye bye");

// Utilidad
// https://developer.wordpress.org/resource/dashicons/#admin-site

// Top level menu del plugin
function scraper_menu_administrador()
{
	add_menu_page( "Simone Scraper", "Simone Scraper",'manage_options', SCRAPER_PATH . '/admin/admin.php', '', 'dashicons-cloud');
    add_submenu_page( SCRAPER_PATH . '/admin/admin.php', 'Sobre Simone Scraper', 'Sobre','manage_options', SCRAPER_PATH . '/admin/about.php');
    add_submenu_page( SCRAPER_PATH . '/admin/admin.php', 'Sobre Simone Scraper', 'Uso interno','manage_options', SCRAPER_PATH . '/admin/new.php');
}
add_action( 'admin_menu', 'scraper_menu_administrador' );

// Añade los css y js
function scraper_add_theme_scripts() {
	wp_enqueue_style( 'datatablecss', plugins_url('public/libraries/datatables/datatables.min.css', SCRAPER_MAIN_FILE));
	wp_enqueue_script( 'datatablejs', plugins_url('public/libraries/datatables/datatables.min.js', SCRAPER_MAIN_FILE));

	wp_enqueue_script( 'sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@9');

	wp_enqueue_style( 'datatablecss', plugins_url('public/css/scraper.css', SCRAPER_MAIN_FILE));
	wp_enqueue_script( 'script_fontawsome', plugins_url('public/libraries/fontawsome/js/all.js', SCRAPER_MAIN_FILE));
	wp_enqueue_script( 'scraper_script', plugins_url('public/js/scraper.js', SCRAPER_MAIN_FILE));
	wp_localize_script( 'scraper_script', 'scraper_vars', ['ajaxurl'=>admin_url( 'admin-ajax.php' )] );
}
add_action( 'admin_enqueue_scripts', 'scraper_add_theme_scripts' );


 ?>