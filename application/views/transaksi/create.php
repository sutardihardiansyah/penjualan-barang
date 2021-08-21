<!-- page heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
	<a href="<?= base_url('transaksi'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali</a>
</div>

<div class="card shadow mb-4">
	<div class="card-body">
		<form action="<?= base_url('transaksi/save'); ?>" method="post">

			<div class="form-group col-md-6">
				<label for="kode_transaksi">Kode Transaksi</label>
				<input type="text" name="kode_transaksi" id="kode_transaksi" class="form-control <?= form_error('kode_transaksi') ? 'is-invalid' : ''; ?>" value="<?= $kode_transaksi; ?>" readonly>
				<div class="invalid-feedback">
					<?= form_error('kode_transaksi'); ?>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="nama_customer">Nama Customer</label>
				<input type="text" name="nama_customer" id="nama_customer" class="form-control <?= form_error('nama_customer') ? 'is-invalid' : ''; ?>" value="<?= set_value('nama_customer'); ?>" required>
				<div class="invalid-feedback">
					<?= form_error('nama_custome'); ?>
				</div>
			</div>
			<hr>
			<div class="col-lg-12">
				<h4>Input Barang</h4>
				<div class="row mt-4">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="">Kode Barang</label>
							<select id="input_kode_barang" class="form-control">
								<option value="">Pilih Barang</option>
								<?php foreach ($barang as $data) : ?>
									<option value="<?= $data['id'] ?>"><?= $data['kode_barang'] ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<label for="qty">Jumlah</label>
							<input type="text" name="" id="input_qty" class="form-control">
						</div>
					</div>
					<div class="col-lg-3">
						<button type="button" class="btn btn-primary mt-4" id="add-barang">Tambah</button>
					</div>
				</div>
				<table class="table table-bordered mt-2" id="table-temp-trans">
					<thead>
						<tr>
							<th>Kode Barang</th>
							<th>Nama Barang</th>
							<th>Harga</th>
							<th>Jumlah</th>
							<th>Total</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

					</tbody>
					<tfoot>
						<tr>
							<th colspan="4" style="text-align:right">Total:</th>
							<th colspan="2" class=""></th>
						</tr>
					</tfoot>
				</table>
			</div>

			<button type="submit" class="btn btn-primary ml-3">Simpan</button>
		</form>
	</div>
</div>
