<!-- Page Heading -->

<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
	<a href="<?= base_url('user/add'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
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
						<th>Nama</th>
						<th>Username</th>
						<th>Email</th>
						<th>Status</th>
						<th class="text-center">
							<i class="fas fa-cog"></i>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($user as $key => $data) : ?>
						<tr>
							<th><?= $key += 1; ?></th>
							<td><?= $data['nama']; ?></td>
							<td><?= $data['username']; ?></td>
							<td><?= $data['email']; ?></td>
							<td class="text-center">
								<?php if ($data['status'] == 1) : ?>
									<span class="badge badge-success">Aktif</span>
								<?php else : ?>
									<span class="badge badge-warning">Non Aktif</span>
								<?php endif; ?>
							</td>
							<td class="text-center">
								<?php if ($data['status'] == 1) : ?>
									<a href="<?= base_url('user/aktif/') . $data['id'] . '/0'; ?>" class="btn btn-warning btn-sm btn-aktivasi" data-user="<?= $data['nama'] ?>" data-status="Non Aktifkan">Non Aktif</a>
								<?php else : ?>
									<a href="<?= base_url('user/aktif/') . $data['id'] . '/1'; ?>" class="btn btn-success btn-sm btn-aktivasi" data-user="<?= $data['nama'] ?>" data-status="Aktifkan">Aktif</a>
								<?php endif; ?>
								<a href="<?= base_url('user/edit/') . $data['id']; ?>" class="btn btn-info btn-sm">Edit</a>
								<a href="<?= base_url('user/delete/') . $data['id']; ?>" class="btn btn-danger btn-sm btn-delete" data-user="<?= $data['nama'] ?>">Hapus</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
