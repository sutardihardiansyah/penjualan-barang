<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->user = $this->session->userdata('user');
		// $this->load->model('barang_model', 'barang');
		is_access($this->uri->segment(1), $this->session->userdata('user'));
	}

	public function index()
	{
		$get_temp = $this->db->get('temp_transaksi')->result_array();

		if (count($get_temp) > 0) {
			foreach ($get_temp as $key => $value) {
				$barang = $this->db->get_where('barang', ['id' => $value['id_barang']])->row_array();

				if ($barang) {
					$new_stok = $value['qty'] + $barang['stok'];
					$this->db->update('barang', ['stok' => $new_stok], ['id' => $value['id_barang']]);
				}
			}
		}

		$this->db->truncate('temp_transaksi');

		if ($this->session->userdata('user')['level'] == 'karyawan') {
			$total 	  	= $this->db->select_sum('total')->where('id_user', $this->session->userdata('user')['id'])->get('transaksi')->row_array();
			$this->db->select('transaksi.*, user.nama');
			$this->db->from('transaksi');
			$this->db->join('user', 'user.id = transaksi.id_user');
			$this->db->where('id_user', $this->session->userdata('user')['id']);
			$transaksi = $this->db->get()->result_array();
		} else {
			$total 	  	= $this->db->select_sum('total')->get('transaksi')->row_array();
			$this->db->select('transaksi.*, user.nama');
			$this->db->from('transaksi');
			$this->db->join('user', 'user.id = transaksi.id_user');
			$transaksi = $this->db->get()->result_array();
		}

		$data = [
			'title'		=> 'Transaksi',
			'transaksi'	=> $transaksi,
			'total'		=> $total
		];
		$this->template->set('title', 'Transaksi');
		$this->template->load('main', 'contents', 'transaksi/index', $data);
	}

	public function add()
	{

		$barang = $this->db->get_where('barang', ['stok >' => 0])->result_array();
		$data = [
			'title'				=> 'Tambah Transaksi',
			'kode_transaksi'	=> 'TRN' . create_kode_tr() . '-' . date('my'),
			'barang'			=> $barang
		];
		$this->template->set('title', 'Tambah Transaksi');
		$this->template->load('main', 'contents', 'transaksi/create', $data);
	}

	public function save()
	{
		$this->form_validation->set_rules('nama_customer', 'Nama Customer', 'required|max_length[255]');

		if ($this->form_validation->run() == false) {
			$this->add();
		} else {

			$data = $this->input->post(null, true);
			$kode_transaksi = $data['kode_transaksi'];
			$nama_customer = $data['nama_customer'];
			$total = $data['total'];

			$data_transaksi = [
				'id_user'			=> $this->user['id'],
				'kode_transaksi'	=> $kode_transaksi,
				'tanggal'			=> date('Y-m-d'),
				'total'				=> $total,
				'nama_customer'		=> $nama_customer
			];

			$this->db->insert('transaksi', $data_transaksi);
			$id_transaksi = $this->db->insert_id();

			$data_temp_trans = [];
			foreach ($data['id_barang'] as $key => $value) {

				$data_detail_trans[] = [
					'id_transaksi'	=> $id_transaksi,
					'id_barang'		=> $value,
					'qty'			=> $data['qty'][$key],
					'harga'			=> $data['harga'][$key],
					'total'			=> $data['qty'][$key] * $data['harga'][$key]
				];
			}

			// simpan detail transaksi
			$this->db->insert_batch('detail_transaksi', $data_detail_trans);

			// hapus data temp transaksi
			$this->db->truncate('temp_transaksi');
			redirect('transaksi');
		}
	}

	public function delete($id = '')
	{
		$delete = $this->db->get_where('transaksi', ['id' => $id])->row_array();

		if ($delete) {
			$delete = $this->db->delete('transaksi', ['id' => $id]);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Berhasil dihapus!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
			redirect('transaksi');
		} else {
			show_404();
		}
	}

	public function detail($id = '')
	{
		$transaksi = $this->db->get_where('transaksi', ['id' => $id])->row_array();

		if ($transaksi) {
			$this->db->select('detail_transaksi.*, barang.nama_barang, barang.kode_barang');
			$this->db->from('detail_transaksi');
			$this->db->join('barang', 'barang.id = detail_transaksi.id_barang');
			$this->db->where('id_transaksi', $id);
			$details = $this->db->get()->result_array();
			$data = [
				'title'			=> 'Detail Transaksi',
				'transaksi'		=> $transaksi,
				'details'		=> $details
			];
			$this->template->set('title', 'Detail Transaksi');
			$this->template->load('main', 'contents', 'transaksi/detail', $data);
		}
	}
	public function get_temp_trans($kode_transaksi)
	{
		$this->db->select('temp_transaksi.*, barang.kode_barang, barang.harga, barang.nama_barang');
		$this->db->from('temp_transaksi');
		$this->db->join('barang', 'barang.id = temp_transaksi.id_barang');
		$this->db->where('kode_transaksi', $kode_transaksi);
		$transaksi = $this->db->get()->result_array();


		$data = [];
		foreach ($transaksi as $key => $value) {
			$row = [];
			$row[] = '<span>' . $value['kode_barang'] . '<input type="hidden" value="' . $value['id_barang'] . '" name="id_barang[]"></span>';
			$row[] = $value['nama_barang'];
			$row[] = '<span>
						Rp. ' . $this->format_rupiah($value['harga']) . '
						<input type="hidden" value="' . $value['harga'] . '" name="harga[]">
					</span>';
			$row[] = '<span>
						<input type="number" min="1" value="' . $value['qty'] . '" name="qty[]" class="form-control btn-qty" data-id="' . $value['id'] . '">
						<input type="hidden" value="' . $value['qty'] . '">
					</span>';
			$row[] = 'Rp. ' . $this->format_rupiah($value['qty'] * $value['harga']) . '';
			$row[] = '<a href="javascript:void(0)" data-title="' . $value['nama_barang'] . '" class="btn btn-danger btn-delete-temp" data-id="' . $value['id'] . '">Hapus</a>';

			$data[] = $row;
		}

		$output = [
			'data'	=> $data
		];
		echo json_encode($output);
	}

	public function save_temp_trans()
	{
		$data_json['error'] = true;
		$data_json['message'] = '';

		$id_barang 		= $this->input->post('id_barang', true);
		$kode_transaksi = $this->input->post('kode_transaksi', true);
		$qty			= $this->input->post('qty', true);

		if (is_numeric($qty)) {
			$data = $this->input->post(null, true);

			$barang = $this->db->get_where('barang', ['id' => $id_barang])->row_array();

			if ($barang) {
				if ($qty < $barang['stok']) {
					$temp_trans = $this->db->get_where('temp_transaksi', ['id_barang' => $id_barang, 'kode_transaksi' => $kode_transaksi])->row_array();

					// update stok barang
					$new_stok = $barang['stok'] - $qty;
					$this->db->update('barang', ['stok' => $new_stok], ['id' => $id_barang]);

					if ($temp_trans) {
						// update qty di temp trans
						$new_qty = $temp_trans['qty'] + $qty;
						$this->db->update('temp_transaksi', ['qty' => $new_qty], ['id_barang' => $id_barang, 'kode_transaksi' => $kode_transaksi]);
					} else {
						$this->db->insert('temp_transaksi', $data);
					}
					$data_json['error'] = false;
				} else {
					$data_json['message'] = 'Jumlah yang ada input lebih besar dari stok!';
				}
			} else {
				$data_json['message'] = 'Kode barang tidak ada';
			}
		} else {
			$data_json['message'] = 'Jumlah harus angka!';
		}

		echo json_encode($data_json);
	}

	public function delete_temp()
	{
		$id = $this->input->post('id', true);

		$get_temp = $this->db->get_where('temp_transaksi', ['id' => $id])->row_array();
		$data_json = [];
		if ($get_temp) {
			// hapus temp
			$this->db->delete('temp_transaksi', ['id' => $id]);

			// update stok
			$barang = $this->db->get_where('barang', ['id' => $get_temp['id_barang']])->row_array();
			$new_stok = $barang['stok'] + $get_temp['qty'];
			$this->db->update('barang', ['stok' => $new_stok], ['id' => $get_temp['id_barang']]);

			$data_json = [
				'error' 	=> false,
				'message'	=> 'Data berhasil dihapus'
			];
		} else {
			$data_json = [
				'error' 	=> true,
				'message'	=> 'Data gagal dihapus'
			];
		}

		echo json_encode($data_json);
	}

	public function update_stok_temp()
	{
		$id = $this->input->post('id', true);
		$qty = $this->input->post('qty', true);

		$get_temp = $this->db->get_where('temp_transaksi', ['id' => $id])->row_array();
		$old_qty = abs($qty - $get_temp['qty']);

		$data_json = [];
		if ($get_temp) {
			// update stok temp
			$this->db->update('temp_transaksi', ['qty' => $qty], ['id' => $id]);

			// update stok barang
			$barang = $this->db->get_where('barang', ['id' => $get_temp['id_barang']])->row_array();
			$stok_awal = $barang['stok'] + $get_temp['qty'];
			$new_stok = $stok_awal - $qty;
			$this->db->update('barang', ['stok' => $new_stok], ['id' => $get_temp['id_barang']]);
		}

		echo json_encode($data_json);
	}

	private function format_rupiah($str)
	{
		return number_format($str, 0, '.', '.');
	}
}
