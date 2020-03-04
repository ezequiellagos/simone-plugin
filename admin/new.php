<?php defined('ABSPATH') or die("Bye bye"); ?>

<?php if (! current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.')); ?>

<?php // Redirect if don't have the id
if ( !isset($_GET['scraper-id']) or $_GET['scraper-id'] == '' ) {
	$url = admin_url( 'admin.php?page=simone-scraper/admin/admin.php'.$row['id'], 'admin' );
	echo "<script>window.location.replace('".$url."');</script>";
}
?>

<?php // Load Data ?>
<?php $data = scraper_get_new($_GET['scraper-id']); ?>


<div class="wrap">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="">
					<h5 class="card-header">Noticia</h5>
					<div class="card-body">
						<form>
							<div class="form-group">
								<label for="exampleInputEmail1">Título</label>
								<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?= $data['title'] ?>">
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Resumen</label>
								<textarea name="" class="form-control" rows="3"><?= $data['lead'] ?></textarea>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Cuerpo</label>
								<textarea name="" class="form-control" rows="15"><?= $data['body'] ?></textarea>
							</div>
							<button type="submit" class="btn btn-primary">Enviar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


