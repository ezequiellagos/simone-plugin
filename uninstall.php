<?php defined('ABSPATH') or die("Bye bye");


if ( !defined('WP_UNINSTALL_PLUGIN') )  die;

// Eliminación Base de Datos
global $wpdb;
$table_name = get_option( 'scraper_table' );
$wpdb->query( "DROP TABLE IF EXISTS " . $table_name );

//Elimina las opciones que se guardan en la BD
delete_option( 'scraper_table' ); 



//delete_option('scraper_mi_opcion'); 
//delete_site_option('scraper_mi_opcion'); //Para multisitios

 ?>