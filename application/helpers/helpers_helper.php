<?php
if (!function_exists('public_url')) {
	function public_url($url = '')
	{
		if ($url) {
			$url = base_url() . 'public/assets/' . $url;
		} else {
			$url = base_url() . 'public/assets/';
		}
		return $url;
	}
}

if (!function_exists('is_access')) {
	function is_access($url, $data)
	{
		$menu_karyawan = ['dashboard', 'transaksi', 'barang', 'laporan'];
		if ($data) {
			if ($data['level'] == 'karyawan') {
				if (!in_array($url, $menu_karyawan)) {
					show_403();
				}
			}
		} else {
			redirect('auth');
		}
	}
}

if (!function_exists('show_403')) {
	function show_403()
	{
		$ci = get_instance();
		$ci->load->view('errors/html/show_403');
	}
}

if (!function_exists('create_kode_brg')) {
	function create_kode_brg()
	{
		$ci = get_instance();

		$barang = $ci->db->order_by('id', 'DESC')->get('barang')->row_array();
		return $barang['id'] + 1;
	}
}

if (!function_exists('create_kode_tr')) {
	function create_kode_tr()
	{
		$ci = get_instance();

		$barang = $ci->db->order_by('id', 'DESC')->get('transaksi')->row_array();
		return $barang['id'] + 1;
	}
}

if (!function_exists('format_rupiah')) {
	function format_rupiah($str)
	{
		return '<span>Rp.</span> ' . number_format($str, 0, '.', '.');
	}
}
