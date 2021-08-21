$(document).ready(function () {

	// tombol hapus
	$('body').on('click', '.btn-delete', function (e) {
		e.preventDefault();

		let href = $(this).attr('href');
		let title = $('.text-gray-800').text();

		Swal.fire({
			title: 'Apakah anda yakin',
			text: title + ' akan dihapus',
			type: 'question',
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
})
