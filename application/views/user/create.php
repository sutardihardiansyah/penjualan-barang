<!-- page heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
	<a href="<?= base_url('user'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"><i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali</a>
</div>

<div class="card shadow mb-4">
	<div class="card-body">
		<form action="<?= base_url('user/add'); ?>" method="post">

			<div class="form-group col-md-6">
				<label for="nama">Nama</label>
				<input type="text" name="nama" id="nama" class="form-control <?= form_error('nama') ? 'is-invalid' : ''; ?>" value="<?= set_value('nama'); ?>" required>
				<div class="invalid-feedback">
					<?= form_error('nama'); ?>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="username">Username</label>
				<input type="text" name="username" id="username" class="form-control <?= form_error('username') ? 'is-invalid' : ''; ?>" value="<?= set_value('username'); ?>" required>
				<div class="invalid-feedback">
					<?= form_error('username'); ?>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="email">Email</label>
				<input type="email" name="email" id="email" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" value="<?= set_value('email'); ?>" required>
				<div class="invalid-feedback">
					<?= form_error('email'); ?>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="level">Level</label>
				<select name="level" id="level" class="form-control <?= form_error('level') ? 'is-invalid' : ''; ?>" required>
					<option value="">Pilih Level</option>
					<option value="karyawan">Karyawan</option>
					<option value="manager">Manager</option>
				</select>
				<div class="invalid-feedback">
					<?= form_error('level'); ?>
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for="status" class="mr-2 d-block">Status Aktif</label>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="status" id="status-1" value="1" checked>
					<label class="form-check-label" for="status-1">Aktif</label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="status" id="status-0" value="option2">
					<label class="form-check-label" for="status-0">Non Aktif</label>
				</div>
				<div class="invalid-feedback">
					<?= form_error('status'); ?>
				</div>
			</div>
			<button type="submit" class="btn btn-primary ml-3">Simpan</button>
		</form>
	</div>
</div>
