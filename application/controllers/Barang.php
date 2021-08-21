<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('barang_model', 'barang');
		is_access($this->uri->segment(1), $this->session->userdata('user'));
	}

	public function index()
	{
		$barang = $this->db->get('barang')->result_array();
		$data = [
			'title'		=> 'Barang',
			'barang'	=> $barang
		];
		$this->template->set('title', 'Barang');
		$this->template->load('main', 'contents', 'barang/index', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|max_length[255]');
		$this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
		$this->form_validation->set_rules('stok', 'Stok', 'required|numeric');

		if ($this->form_validation->run() == false) {
			$data = [
				'title'			=> 'Tambah Barang',
				'kode_barang'	=> 'BRG' . create_kode_brg() . '/' . date('my')
			];
			$this->template->set('title', 'Tambah Barang');
			$this->template->load('main', 'contents', 'barang/create', $data);
		} else {
			$data = $this->input->post(null, true);

			$save = $this->db->insert('barang', $data);

			if ($save) {
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Berhasil disimpan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
				redirect('barang');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Data gagal disimpan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
				redirect('barang');
			}
		}
	}

	public function edit($id = '')
	{
		$data = $this->db->get_where('barang', ['id' => $id])->row_array();

		if ($data) {
			$data = [
				'title'			=> 'Edit Barang',
				'barang'		=> $data
			];
			$this->template->set('title', 'Edit Barang');
			$this->template->load('main', 'contents', 'barang/edit', $data);
		} else {
			show_404();
		}
	}

	public function update()
	{
		$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'required');
		$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|max_length[255]');
		$this->form_validation->set_rules('harga', 'Harga', 'required|numeric');
		$this->form_validation->set_rules('stok', 'Stok', 'required|numeric');

		if ($this->form_validation->run() == false) {
			$this->edit($this->input->post('id'));
		} else {
			$data = $this->input->post(null, true);
			$id = $data['id'];
			unset($data['id']);

			$update = $this->db->update('barang', $data, ['id' => $id]);

			if ($update) {
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Berhasil diubah!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
				redirect('barang');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Data gagal diubah!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
				redirect('barang');
			}
		}
	}

	public function delete($id = '')
	{
		$delete = $this->db->get_where('barang', ['id' => $id])->row_array();

		if ($delete) {
			$delete = $this->db->delete('barang', ['id' => $id]);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Berhasil dihapus!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
			redirect('barang');
		} else {
			show_404();
		}
	}
}
