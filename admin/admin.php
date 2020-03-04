<?php defined('ABSPATH') or die("Bye bye"); ?>

<?php if (! current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.')); ?>

<!-- <div class="wrap">
	<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<h1 class="display-4">Simone Scraper</h1>
			<p class="lead">Bienvenido a la pantalla de seleccion de noticias</p>
		</div>
	</div>
</div> -->

<div class="wrap">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<table id="table_news" class="table table-bordered table-hover table-sm display">
					<thead>
						<tr>
							<th>Id</th>
							<th>Título</th>
							<th>Institución</th>
							<th>Categoría</th>
							<th>Fecha</th>
							<th>Acción</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	jQuery(document).ready( function(){

		// var mensaje = Swal.fire('Any fool can use a computer');

		var buttonTitle = "Noticias Simone Obtenidas Automáticamente";
		var table = jQuery('#table_news').DataTable({
			'language': {
				'url': '<?= plugins_url('public/libraries/datatables/Spanish.json', SCRAPER_MAIN_FILE) ?>',
			},
			// 'responsive': true,
			"order": [[ 0, "desc" ]],
			"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"] ],
			'processing': true,
			'serverSide': true,
			'serverMethod': 'post',
			'ajax': {
				'url': scraper_vars.ajaxurl,
				'dataType' : "json",
				'data': {
					action: 'scraper_get_news'
				}
			},
			'columns':[
				{ 
					data: 'id',
					className: "text-center align-middle", 
				},
				{ data: 'title' },
				{ data: 'institution' },
				{ data: 'category' },
				{ 
					data: 'date',
					render: function (data, type, row) {
						// return type === 'export' ? data.replace( /[$,]/g, '' ) : data;
						data = Date.createFromMysql(data);
						// var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };}
						data = data.toLocaleDateString("es-CL")
						return data;
					} 
				},
				{
					data: 'url_edit',
					className: "center",
					render: function (data, type, row) {
						html = '<div class="btn-group" role="group" aria-label="Acciones">'+
									'<a href="'+data+'" class="btn btn-warning btn-sm"><i class="fas fa-external-link-alt"></i></a> '+
									'<button class="newPreview btn btn-primary btn-sm"><i class="fas fa-eye"></i></button> '+
									'<button class="newDelete btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button> '+
								'</div>';
						return html;
					},
					className: "text-center align-middle"
				}
			],
			'dom': '<"row"<"col"l><"col"f>> rt <"row"<"col"i><"col"p>> B',
			'buttons': [
				{
					extend: 'print',
					className: 'btn-primary',
					text: 'Imprimir',
					autoPrint: true,
					title: buttonTitle,
					init: function(api, node, config) {
						jQuery(node).removeClass('btn-secondary')
					}
				},
				{
					extend: 'excel',
					className: 'btn-success ',
					text: 'Excel',
					title: buttonTitle,
					init: function(api, node, config) {
						jQuery(node).removeClass('btn-secondary')
					}
				},
				{
					extend: 'pdf',
					className: 'btn-danger',
					text: 'PDF',
					title: buttonTitle,
					init: function(api, node, config) {
						jQuery(node).removeClass('btn-secondary')
					}
				},
				{
					extend: 'copy',
					className: 'btn-warning',
					text: 'Copiar',
					title: buttonTitle,
					init: function(api, node, config) {
						jQuery(node).removeClass('btn-secondary')
					}
				},
				{
					extend: 'colvis',
					className: 'btn-secondary',
					text: 'Columnas',
					init: function(api, node, config) {
						jQuery(node).removeClass('btn-secondary')
					}
				}
			],
		});

		// Delete New
		jQuery('#table_news tbody').on('click', '.newDelete', function () {
			var row = jQuery(this).closest('tr');
			var id = table.row( row ).data()["id"];
			var title = table.row( row ).data()["title"];
			var lead = table.row( row ).data()["lead"];
			var url_new = table.row( row ).data()["url_new"];
			var date = table.row( row ).data()["date"];

			Swal.fire({
				title: '¿Desea eliminar la noticia?',
				icon: 'question',
				html:
					'<strong>' + title + '</strong>',
				showCloseButton: true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si, eliminar',
				focusCancel: true
			}).then( (result) => {
				if ( result.value ) {
					// Agregar logica de eliminación de noticia
					Swal.fire(
						'Deleted!',
						'Your file has been deleted.',
						'success'
					)
				}
			});
		});

		// Preview New
		jQuery('#table_news tbody').on('click', '.newPreview', function () {
			var row = jQuery(this).closest('tr');
			var id = table.row( row ).data()["id"];
			var title = table.row( row ).data()["title"];
			var lead = table.row( row ).data()["lead"];
			var url_new = table.row( row ).data()["url_new"];
			var date = table.row( row ).data()["date"];

			Swal.fire({
				title: '<strong>' + title + '</strong>',
				// icon: 'info',
				html:
					'Resumen: <br />'+
					'<div class="table-responsive"><p class="">'+lead+'</p></div>'+
					'<p><a href="'+url_new+'" target="_blank">'+url_new+'</a></p>'+
					'<p>'+date+'</p>',
				showCloseButton: true,
				// showCancelButton: true,
				// focusConfirm: false,
				// confirmButtonText:
				// 	'<i class="fa fa-thumbs-up"></i> Great!',
				// confirmButtonAriaLabel: 'Thumbs up, great!',
				// cancelButtonText:
				// 	'<i class="fa fa-thumbs-down"></i>',
				// cancelButtonAriaLabel: 'Thumbs down'
			});
		});



	});

</script>
