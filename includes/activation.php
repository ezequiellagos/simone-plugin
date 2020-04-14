<?php defined('ABSPATH') or die("Bye bye");

function scraper_activar()
{
	//A partir de aquí escribe todas las tareas que quieres realizar en la activación
	//Vas a añadir una función nueva. La sintaxis de add_option es la siguiente:add_option($nombre,$valor,'',$cargaautomatica)
	// add_option('scraper_mi_opcion', '255', '', 'yes'); // ejemplo

	global $table_prefix, $wpdb;
	$charset_collate = $wpdb->get_charset_collate();

	$tblname = 'scraper';
	$wp_track_table = $table_prefix . $tblname;

	#Check to see if the table exists already, if not, then create it
	if( $wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table ) 
	{
		$sql = "CREATE TABLE $wp_track_table (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`institution` varchar(100) NOT NULL,
			`url_base` varchar(255) NOT NULL,
			`url_news` varchar(255) NOT NULL,
			`url_new` varchar(300) NOT NULL,
			`title` varchar(255) NOT NULL,
			`lead` varchar(500) DEFAULT NULL,
			`category` varchar(100) DEFAULT 'sin categoría',
			`date` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			`img` varchar(500) DEFAULT NULL,
			`body` text DEFAULT NULL,
			`body_full` text DEFAULT NULL,
			`show` tinyint(1) DEFAULT 1,
			PRIMARY KEY (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	add_option('scraper_table', $wp_track_table, '', 'yes'); // nombre de la tabla

}
register_activation_hook( SCRAPER_MAIN_FILE, 'scraper_activar');


function scraper_desactivar()
{
	//A partir de aqui escribe todas las tareas que quieres realizar en la desactivación
	// delete_option( 'scraper_mi_opcion' );

}
register_deactivation_hook( SCRAPER_MAIN_FILE, 'scraper_desactivar');




 ?>