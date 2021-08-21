<!-- page heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
	<a href="<?= base_url('transaksi'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali</a>
</div>
<!-- DataTales Example -->
<div class="card shadow mb-4">
	<div class="card-header py-3 border-0 bg-white">
		<?php if ($this->session->flashdata('message')) : ?>
			<?= $this->session->flashdata('message'); ?>
		<?php endif; ?>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="form-group col-md-6">
				<label for="kode_transaksi">Kode Transaksi</label>
				<input type="text" name="kode_transaksi" id="kode_transaksi" class="form-control <?= form_error('kode_transaksi') ? 'is-invalid' : ''; ?>" value="<?= $transaksi['kode_transaksi']; ?>" readonly>
				<div class="invalid-feedback">
					<?= form_error('kode_transaksi'); ?>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="nama_customer">Nama Customer</label>
				<input type="text" name="nama_customer" id="nama_customer" class="form-control <?= form_error('nama_customer') ? 'is-invalid' : ''; ?>" value="<?= $transaksi['nama_customer']; ?>" required readonly>
				<div class="invalid-feedback">
					<?= form_error('nama_custome'); ?>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th>Kode Barang</th>
						<th>Nama Barang</th>
						<th>Harga</th>
						<th>Jumlah</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php $total = [] ?>
					<?php foreach ($details as $key => $data) : ?>
						<?php $total[] = $data['total']; ?>
						<tr>
							<th><?= $key += 1; ?></th>
							<td><?= $data['kode_barang']; ?></td>
							<td><?= $data['nama_barang']; ?></td>
							<td><?= format_rupiah($data['harga']); ?></td>
							<td><?= $data['qty']; ?></td>
							<td><?= format_rupiah($data['total']); ?></td>

						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="5" class="text-right">Total</th>
						<th><?= format_rupiah(array_sum($total)); ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
