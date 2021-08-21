<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
	<a href="<?= base_url('transaksi/add'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
	<div class="card-header py-3 border-0 bg-white">
		<?php if ($this->session->flashdata('message')) : ?>
			<?= $this->session->flashdata('message'); ?>
		<?php endif; ?>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>#</th>
						<th>Kode Transaksi</th>
						<th>Nama User</th>
						<th>Nama Customer</th>
						<th>Tanggal</th>
						<th>Total</th>
						<th class="text-center">
							<i class="fas fa-cog"></i>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($transaksi as $key => $data) : ?>
						<tr>
							<th><?= $key += 1; ?></th>
							<td><?= $data['kode_transaksi']; ?></td>
							<td><?= $data['nama']; ?></td>
							<td><?= $data['nama_customer'] ? $data['nama_customer'] : '-'; ?></td>
							<td><?= $data['tanggal']; ?></td>
							<td><?= format_rupiah($data['total']); ?></td>
							<td class="text-center">
								<!-- <a href="<?= base_url('transaksi/edit/') . $data['id']; ?>" class="btn btn-info btn-sm">Edit</a> -->
								<a href="<?= base_url('transaksi/detail/') . $data['id']; ?>" class="btn btn-info btn-sm">Detail</a>
								<a href="<?= base_url('transaksi/delete/') . $data['id']; ?>" data-title="<?= $data['kode_transaksi'] ?>" class="btn btn-danger btn-sm btn-delete-trans" data-barang="<?= $data['kode_transaksi'] ?>">Hapus</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
