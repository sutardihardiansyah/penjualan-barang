<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
	<a href="<?= base_url('laporan/transaksi/export_excel'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" target="_blank"><i class="fas fa-file-excel-o fa-sm text-white-50"></i> Export Excel</a>
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
						<th>Tanggal</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($transaksi as $key => $data) : ?>
						<tr>
							<th><?= $key += 1; ?></th>
							<td><?= $data['kode_transaksi']; ?></td>
							<td><?= $data['tanggal']; ?></td>
							<td><?= format_rupiah($data['total']); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="2"></th>
						<th>Total</th>
						<th><?= format_rupiah($total['total']) ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
