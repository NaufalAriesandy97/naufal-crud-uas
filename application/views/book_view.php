<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"> 
	<title>UAS Aplikasi CRUD Sederhana</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ;?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css') ;?>">
</head>
<body>

	<div class="container">
		<h1>Belajar Codeigneter</h1>
		<h3>Aplikasi Buku Sederhana</h3>

		<button type="button" class="btn btn-success" onclick="add_book()"><i class="glyphicon glyphicon-plus"></i>Tambah Buku</button>
		<br>
		<br>

		<table id="table_id" class="table table-stripped table-bordered">
			<thead>
				<tr>
					<th>Id Buku</th>
					<th>ISBN Buku</th>
					<th>Judul Buku</th>
					<th>Penulis Buku</th>
					<th>Kategori Buku</th>
					<th>Aksi</th>
				</tr>
			</thead>

			<tbody>
			<?php 
			foreach ($books as $b) 
			{
			?>
				<tr>
					<td><?php echo $b->id_buku ;?></td>
					<td><?php echo $b->isbn_buku ;?></td>
					<td><?php echo $b->judul_buku ;?></td>
					<td><?php echo $b->penulis_buku ;?></td>
					<td><?php echo $b->kategori_buku ;?></td>
					<td>
						<button class="btn btn-warning" onclick="edit_book(<?php echo $b->id_buku ;?>)"><i class="glyphicon glyphicon-pencil"></i></button>

						<button class="btn btn-danger" onclick="delete_book(<?php echo $b->id_buku ;?>)"><i class="glyphicon glyphicon-remove"></i></button>
					</td>
				</tr>
			<?php 
			}
			?>
			</tbody>
		</table>
	</div>



	<!-- Link untuk memanggil ke JS -->
	<script src="<?php echo base_url('assets/jquery/jquery-3.3.1.min.js') ;?>"></script>

	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ;?>"></script>

	<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js') ;?>"></script>

	<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js') ;?>"></script>

	<!-- Link untuk memanggil tabel JS -->
	<script type="text/javascript">
		$(document).ready(function() {
			$('#table_id').DataTable();
		});

		var save_method;
		var table;

		function add_book()
		{
			save_method = 'add';
			$('#form')[0].reset();
			$('#modal_form').modal('show');
		}

		function save()
		{
			var url;

			if (save_method == 'add')
			{
				url = '<?php echo site_url('index.php/Book/book_add') ;?>';
			} 
			else
				{
					url = '<?php echo site_url('index.php/Book/book_update') ;?>';
				}

			$.ajax({
				url: url,
				type: "POST",
				data: $('#form').serialize(),
				datatype: "JSON",
				success: function(data) 
				{
					$('#modal_form').modal('hide');
					location.reload();
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
					alert('Gagal tambah data / Ubah data');
				}
			});
		}

		function edit_book(id)
		{
			save_method = 'update';
			$('#form')[0].reset();

			$.ajax({
				url: "<?php echo site_url('index.php/book/ajax_edit/') ;?>/"+id,
				type: "GET",
				dataType: "JSON",
				success: function(data)
				{
					$('[name="id_buku"]').val(data.id_buku);
					$('[name="isbn_buku"]').val(data.isbn_buku);
					$('[name="judul_buku"]').val(data.judul_buku);
					$('[name="penulis_buku"]').val(data.penulis_buku);
					$('[name="kategori_buku"]').val(data.kategori_buku);

					$('#modal_form').modal('show');

					$('.modal-title').text('Edit Data');					
				},
				error: function(jqXHR, textStatus, errorThrown)
				{
					alert('Gagal tambah data / Ubah data');
				}
			})
		}

		function delete_book(id)
		{
			if(confirm('Apakah anda yakin menghapus data ini?'))
			{
				$.ajax({
					url: "<?php echo site_url('index.php/book/book_delete') ;?>/"+id,
					type: "POST",
					dataType: "JSON",
					success: function(data)
					{
						location.reload();
					},
					error: function(jqXHR, textStatus, errorThrown)
					{
						alert('Gagal hapus data');
					}
				})
			};
		}
	</script>

	<!-- Membuat modal untuk tambah buku -->
	<div class="modal fade" id="modal_form" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Tambah Data Buku</h4>
	      </div>
	      <div class="modal-body form">
	      	<form action="#" id="form" class="form-horizontal">
	      	<input type="hidden" value="" name="id_buku">

	      		<div class="form-body">
	      			<div class="form-group">
	      				<label class="control-label col-md-3">ISBN Buku</label>
	      				<div class="col-md-9">
	      					<input type="text" name="isbn_buku" placeholder="ISBN Buku" class="form-control">
	      				</div>
	      			</div>
	      		</div>

	      		<div class="form-body">
	      			<div class="form-group">
	      				<label class="control-label col-md-3">Judul Buku</label>
	      				<div class="col-md-9">
	      					<input type="text" name="judul_buku" placeholder="Judul Buku" class="form-control">
	      				</div>
	      			</div>
	      		</div>

	      		<div class="form-body">
	      			<div class="form-group">
	      				<label class="control-label col-md-3">Penulis Buku</label>
	      				<div class="col-md-9">
	      					<input type="text" name="penulis_buku" placeholder="Penulis Buku" class="form-control">
	      				</div>
	      			</div>
	      		</div>

	      		<div class="form-body">
	      			<div class="form-group">
	      				<label class="control-label col-md-3">Kategori Buku</label>
	      				<div class="col-md-9">
	      					<input type="text" name="kategori_buku" placeholder="Kategori Buku" class="form-control">
	      				</div>
	      			</div>
	      		</div>
	      		
	      	</form>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" onclick="save()" class="btn btn-primary">Simpan Data</button>
	      </div>
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</body>
</html>