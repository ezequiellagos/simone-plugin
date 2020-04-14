<?php defined('ABSPATH') or die("Bye bye"); ?>
<?php 

function scraper_new_post($id)
{
	if ( !is_numeric($id) ) {
		$response = array(
			'status' => 'error', 
			'message' => 'La noticia no es válida', 
		);
		return json_encode($response);
	}

	global $wpdb;
	$table_name = get_option( 'scraper_table' );
	

	$result = $wpdb->get_row( "SELECT * FROM  $table_name WHERE id = '$id';") ;
	echo $result->name;


	// $post = array(
	// 	'post_title'   => wp_strip_all_tags( $_POST['post_title'] ),
	// 	'post_content' => $_POST['post_content'],
	// 	'post_status'  => 'publish',
	// );

	// wp_insert_post( sanitize_post( $post, 'display' ) );
}

// Funcion obtener noticia
function scraper_get_new($id)
{
	global $wpdb;
	$table_name = get_option( 'scraper_table' );
	$result = $wpdb->get_row( "SELECT * FROM {$table_name} WHERE id = {$id} LIMIT 1 ;", ARRAY_A);

	return $result;
}

// Eliminar Noticia
function scraper_delete_new($id = 0)
{
	if ( $id != 0 AND !is_null($id)) {
		global $wpdb;
		$table_name = get_option( 'scraper_table' );
		$result = $wpdb->query( "UPDATE {$table_name} SET show = 0 WHERE id = {$id} ;", ARRAY_A);
		$result = $wpdb->update( $table_name, ['show' => '1'] );
		if ($result === false) {
			// Error
		} else {
			// Todo ok
		}

	}
}

// Función para AJAX
function scraper_get_news()
{
	global $wpdb;
	$table_name = get_option( 'scraper_table' );

	$draw = $_POST['draw'];
	$row = $_POST['start'];
	$rowperpage = $_POST['length'];
	$columnIndex = $_POST['order'][0]['column'];
	$columnName = $_POST['columns'][$columnIndex]['data'];
	$columnSortOrder = $_POST['order'][0]['dir'];
	$searchValue = $_POST['search']['value'];

	// Search
	$searchQuery = " ";
	if ( $searchValue != '' ) {
		$searchQuery = " AND (title LIKE '%{$searchValue}%' OR institution LIKE '%{$searchValue}%') ";
	}

	// Total number of records without filter
	$result = $wpdb->get_row( "SELECT COUNT(*) AS allcount FROM  $table_name ;") ;
	$totalRecords = $result->allcount;

	// Total number of records with filter
	$result = $wpdb->get_row( "SELECT COUNT(*) AS allcount FROM $table_name WHERE 1 $searchQuery") ;
	$totalRecordswithFilter = $result->allcount;

	// Fetch records
	if ( $rowperpage == -1 ) $rowperpage = $totalRecords; // All rows
	$result = $wpdb->get_results( "SELECT * FROM $table_name WHERE 1 $searchQuery ORDER BY $columnName $columnSortOrder LIMIT {$row}, {$rowperpage} ", 'ARRAY_A') ;
	if ( !empty( $result ) ) {
		foreach ($result as $row) {
			$data[] = array(
				'id' => $row['id'],
				'institution' => $row['institution'],
				'url_base' => $row['url_base'],
				'url_news' => $row['url_news'],
				'url_new' => $row['url_new'],
				'title' => $row['title'],
				'lead' => $row['lead'],
				'category' => $row['category'],
				'date' => $row['date'],
				'img' => $row['img'],
				'body' => $row['body'],
				'body_full' => $row['body_full'],
				'url_edit' => admin_url( 'admin.php?page=simone-scraper/admin/new.php&scraper-id='.$row['id'], 'admin' )
			);
		}
	} else {
		$msgNoData = "sin información";
		$data[] = array(
			'id' => $msgNoData,
			'institution' => $msgNoData,
			'url_base' => $msgNoData,
			'url_news' => $msgNoData,
			'url_new' => $msgNoData,
			'title' => $msgNoData,
			'lead' => $msgNoData,
			'category' => $msgNoData,
			'date' => $msgNoData,
			'img' => $msgNoData,
			'body' => $msgNoData,
			'body_full' => $msgNoData,
			'url_edit' => admin_url( 'admin.php?page=simone-scraper/admin/admin.php', 'admin' )
		);
	}

	// Response
	$response = array(
		"draw" => intval($draw),
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordswithFilter,
		"aaData" => $data
	);

	echo json_encode($response);
	wp_die();
}
add_action( 'wp_ajax_nopriv_scraper_get_news', 'scraper_get_news' );
add_action( 'wp_ajax_scraper_get_news', 'scraper_get_news' );
add_action( 'wp_ajax_scraper_delete_new', 'scraper_delete_new' );


 ?>
