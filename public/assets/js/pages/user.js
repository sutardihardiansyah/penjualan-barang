$(document).ready(function() {

	// tombol hapus
	$('body').on('click', '.btn-delete', function(e) {
		e.preventDefault();
		let href = $(this).attr('href');
		let title = $(this).data('user');

		Swal.fire({
			title: 'Apakah anda yakin ?',
			text: title + ' akan dihapus',
			// type: 'question',
			showCancelButton: true,
			confirmButtonClass: 'btn btn-primary',
			cancelButtonClass: 'btn btn-danger',
			confirmButtonText: 'Hapus Data!'
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		});
	})

	// tombol aktivasi
	$('body').on('click', '.btn-aktivasi', function(e) {
		e.preventDefault();
		let href = $(this).attr('href');
		let title = $(this).data('user');
		let status = $(this).data('status');

		Swal.fire({
			title: 'Apakah anda yakin ?',
			text: title + ' akan di ' + status,
			// type: 'question',
			showCancelButton: true,
			confirmButtonClass: 'btn btn-primary',
			cancelButtonClass: 'btn btn-danger',
			confirmButtonText: status
		}).then((result) => {
			if (result.value) {
				document.location.href = href;
			}
		});
	})
})
