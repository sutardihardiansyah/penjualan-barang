<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title><?= $title; ?></title>

	<!-- Custom fonts for this template-->
	<link href="<?= public_url(); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="<?= public_url(); ?>css/sb-admin-2.min.css" rel="stylesheet">

	<!-- Custom styles for this page -->
	<link href="<?= public_url(); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="<?= public_url(); ?>css/component.css" rel="stylesheet">
</head>

<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
				<div class="sidebar-brand-icon rotate-n-15">
					<i class="fas fa-tools"></i>
				</div>
				<div class="sidebar-brand-text mx-3 text-uppercase">Penjualan</div>
			</a>

			<!-- Divider -->
			<hr class="sidebar-divider my-0">

			<!-- Nav Item - Dashboard -->
			<li class="nav-item">
				<a class="nav-link" href="index.html">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Dashboard</span></a>
			</li>
			<hr class="sidebar-divider">

			<?php if ($this->session->userdata('user')['level'] == 'karyawan' || $this->session->userdata('user')['level'] == 'manager') : ?>
				<div class="sidebar-heading">Master Data</div>
				<li class="nav-item">
					<a class="nav-link" href="<?= base_url('barang'); ?>">
						<i class="fas fa-fw fa-cube"></i>
						<span>Barang</span></a>
				</li>

				<hr class="sidebar-divider">
				<div class="sidebar-heading">Transaksi</div>
				<li class="nav-item">
					<a class="nav-link" href="<?= base_url('transaksi'); ?>">
						<i class="fas fa-fw fa-shopping-cart"></i>
						<span>Transaksi</span></a>
				</li>

				<hr class="sidebar-divider">
				<div class="sidebar-heading">Laporan</div>
				<li class="nav-item">
					<a class="nav-link" href="<?= base_url('laporan/transaksi'); ?>">
						<i class="fas fa-fw fa-chart-bar"></i>
						<span>Laporan Transaksi</span></a>
				</li>
			<?php endif; ?>
			<?php if ($this->session->userdata('user')['level'] == 'manager') : ?>
				<hr class="sidebar-divider">
				<div class="sidebar-heading">User Management</div>
				<li class="nav-item">
					<a class="nav-link" href="<?= base_url('user'); ?>">
						<i class="far fa-fw fa-user"></i>
						<span>User</span></a>
				</li>
			<?php endif; ?>
			<!-- Divider -->
			<hr class="sidebar-divider d-none d-md-block">

			<!-- Sidebar Toggler (Sidebar) -->
			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>

		</ul>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>

					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">

						<!-- Nav Item - Search Dropdown (Visible Only XS) -->
						<li class="nav-item dropdown no-arrow d-sm-none">
							<a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-search fa-fw"></i>
							</a>
							<!-- Dropdown - Messages -->
							<div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
								<form class="form-inline mr-auto w-100 navbar-search">
									<div class="input-group">
										<input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
										<div class="input-group-append">
											<button class="btn btn-primary" type="button">
												<i class="fas fa-search fa-sm"></i>
											</button>
										</div>
									</div>
								</form>
							</div>
						</li>

						<div class="topbar-divider d-none d-sm-block"></div>

						<!-- Nav Item - User Information -->
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata('user')['nama']; ?></span>
								<img class="img-profile rounded-circle" src="<?= public_url(); ?>img/user.png">
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="#">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									Profile
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#logoutModal">
									<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
									Logout
								</a>
							</div>
						</li>

					</ul>

				</nav>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">
					<?= $contents ?>
				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright &copy; Your Website <?= date('Y'); ?></span>
					</div>
				</div>
			</footer>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="<?= base_url('auth/logout'); ?>">Logout</a>
				</div>
			</div>
		</div>
	</div>

	<script>
		var url = '<?= base_url(); ?>'
	</script>
	<!-- Bootstrap core JavaScript-->
	<script src="<?= public_url(); ?>vendor/jquery/jquery.min.js"></script>
	<script src="<?= public_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="<?= public_url(); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="<?= public_url(); ?>js/sb-admin-2.min.js"></script>

	<!-- Page level plugins -->
	<script src="<?= public_url(); ?>vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= public_url(); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="<?= public_url(); ?>vendor/sweetalert/sweetalert2.all.js"></script>

	<!-- Page level custom scripts -->
	<script src="<?= public_url(); ?>js/demo/datatables-demo.js"></script>
	<script src="<?= public_url(); ?>js/demo/sweetalert.js"></script>

	<!-- Datepicker -->
	<script src="<?= public_url(); ?>vendor/datepicker/ui/moment/moment.min.js"></script>
	<script src="<?= public_url(); ?>vendor/datepicker/pickers/daterangepicker.js"></script>
	<script src="<?= public_url(); ?>vendor/datepicker/pickers/anytime.min.js"></script>
	<script src="<?= public_url(); ?>vendor/datepicker/pickers/pickadate/picker.js"></script>
	<script src="<?= public_url(); ?>vendor/datepicker/pickers/pickadate/picker.date.js"></script>
	<script src="<?= public_url(); ?>vendor/datepicker/pickers/pickadate/picker.time.js"></script>
	<script src="<?= public_url(); ?>vendor/datepicker/pickers/pickadate/legacy.js"></script>

	<!-- Javascript Page -->
	<script src="<?= public_url(); ?>js/pages/barang.js"></script>
	<script src="<?= public_url(); ?>js/pages/user.js"></script>
	<script src="<?= public_url(); ?>js/pages/transaksi.js"></script>
</body>

</html>
