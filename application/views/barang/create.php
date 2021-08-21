<!-- page heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
	<a href="<?= base_url('barang'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali</a>
</div>

<div class="card shadow mb-4">
	<div class="card-body">
		<form action="<?= base_url('barang/add'); ?>" method="post">

			<div class="form-group col-md-6">
				<label for="kode_barang">Kode Barang</label>
				<input type="text" name="kode_barang" id="kode_barang" class="form-control <?= form_error('kode_barang') ? 'is-invalid' : ''; ?>" value="<?= $kode_barang; ?>" readonly>
				<div class="invalid-feedback">
					<?= form_error('kode_barang'); ?>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="nama_barang">Nama Barang</label>
				<input type="text" name="nama_barang" id="nama_barang" class="form-control <?= form_error('nama_barang') ? 'is-invalid' : ''; ?>" value="<?= set_value('nama_barang'); ?>">
				<div class="invalid-feedback">
					<?= form_error('nama_barang'); ?>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="harga">Harga</label>
				<input type="text" name="harga" id="harga" class="form-control <?= form_error('harga') ? 'is-invalid' : ''; ?>" value="<?= set_value('harga'); ?>">
				<div class="invalid-feedback">
					<?= form_error('harga'); ?>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="stok">Stok</label>
				<input type="text" name="stok" id="stok" class="form-control <?= form_error('stok') ? 'is-invalid' : ''; ?>" value="<?= set_value('stok'); ?>">
				<div class="invalid-feedback">
					<?= form_error('stok'); ?>
				</div>
			</div>
			<button type="submit" class="btn btn-primary ml-3">Simpan</button>
		</form>
	</div>
</div>
