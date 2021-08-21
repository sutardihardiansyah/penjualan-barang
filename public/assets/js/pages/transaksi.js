$(document).ready(function() {
	console.log(url);
	let kode_transaksi = $('body #kode_transaksi').val();
	$('body').on('change', '#barang-0 #kode-barang', function() {
		$.ajax()
		$('#barang-0 #nama-barang')
	})

	// tombol hapus
	$('body').on('click', '.btn-delete-trans', function(e) {
		e.preventDefault();
		let href = $(this).attr('href');
		let title = $(this).data('title');

		Swal.fire({
			title: 'Apakah anda yakin',
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

	// setting datatable serversid
	var table = $('body #table-temp-trans').DataTable({
		"processing": true, 
        "serverSide": true,
		"ajax": {
			"url": url+"transaksi/get_temp_trans/"+kode_transaksi,
			"type": "GET"
		},
		"paging":   false,
        "ordering": false,
        "info":     false,
		"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
			console.log(api);
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\Rp.]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column(4)
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
			
            // Total over this page
            pageTotal = api
                .column(4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(4).footer() ).html(
				// '$'+pageTotal +' ( $'+ total +' total)';
                'Rp. ' + formatRupiah(total) + '<input name="total" type="hidden" id="total" value="'+total+'">'
            );
        }
	});

	// tambah barang
	$('body').on('click', '#add-barang', function() {
		let id_barang = $('body #input_kode_barang').val();
		let qty = $('body #input_qty').val();

		$(this).text('Loading...');
		$(this).attr('disabled', 'disabled');

		if(id_barang == '' || qty == '') {
			Swal.fire(
				'',
				'Kode Barang atau Jumlah tidak boleh kosong',
				'error'
			)
			$('body #add-barang').text('Tambah');
			$('body #add-barang').removeAttr('disabled');
		} else {
			$.ajax({
				url : url+'transaksi/save_temp_trans',
				type: "POST",
				data : {
					'kode_transaksi' : kode_transaksi,
					'id_barang' : id_barang,
					'qty'	: qty
				},
				dataType : "JSON",
				success : function(result) {
					
					$('body #add-barang').text('Tambah');
					$('body #add-barang').removeAttr('disabled');
					$('body #input_qty').val('');
					
					if(result.error) {
						Swal.fire(
							'',
							result.message,
							'error'
						)
					} else {
						table.ajax.reload();
					}
				}
			})
		}
	})

	// tombol delete temp
	$('body').on('click', '.btn-delete-temp', function() {
		let id = $(this).data('id');
		let title = $(this).data('title');

		Swal.fire({
			title: 'Apakah anda yakin',
			text: title + ' akan dihapus',
			// type: 'question',
			showCancelButton: true,
			confirmButtonClass: 'btn btn-primary',
			cancelButtonClass: 'btn btn-danger',
			confirmButtonText: 'Hapus Data!'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url : url + 'transaksi/delete_temp',
					type : 'POST',
					dataType : "JSON",
					data : {
						'id' : id
					},
					success : function(res) {
						if(res.error) {
							Swal.fire(
								'',
								result.message,
								'error'
							)
						} else {
							table.ajax.reload()
							Swal.fire(
								'',
								res.message,
								'success'
							)
						}
					}
				})
			}
		});
		
	})

	// update qty
	$('body').on('click', '.btn-qty', function() {
		let id = $(this).data('id');
		let qty = $(this).val();
		
		$.ajax({
			url : url + 'transaksi/update_stok_temp',
			type : 'POST',
			dataType : "JSON",
			data : {
				'id' : id,
				'qty' : qty
			},
			success : function(res) {
				table.ajax.reload()
			}
		})
	})

	function formatRupiah(bilangan, prefix){
		
		var	number_string = bilangan.toString(),
		sisa 	= number_string.length % 3,
		rupiah 	= number_string.substr(0, sisa),
		ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
			
		if (ribuan) {
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}
})
