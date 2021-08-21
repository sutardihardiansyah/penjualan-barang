<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', 'user');
		is_access($this->uri->segment(1), $this->session->userdata('user'));
	}

	public function index()
	{
		$user = $this->db->get('user')->result_array();
		$data = [
			'title'		=> 'User Management',
			'user'	=> $user
		];
		$this->template->set('title', 'User Management');
		$this->template->load('main', 'contents', 'user/index', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required|max_length[255]');
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[255]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		// $this->form_validation->set_rules('password', 'Password', 'required|max_length[255]');
		$this->form_validation->set_rules('level', 'Level', 'required|max_length[30]');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run() == false) {
			$data = [
				'title'			=> 'Tambah User'
			];
			$this->template->set('title', 'Tambah User');
			$this->template->load('main', 'contents', 'user/create', $data);
		} else {
			$data = $this->input->post(null, true);
			$data['password'] = password_hash('password', PASSWORD_DEFAULT);

			$save = $this->db->insert('user', $data);

			if ($save) {
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Berhasil disimpan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
				redirect('user');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Data gagal disimpan!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
				redirect('user');
			}
		}
	}

	public function edit($id = '')
	{
		$data = $this->db->get_where('user', ['id' => $id])->row_array();

		if ($data) {
			$data = [
				'title'			=> 'Edit User',
				'user'		=> $data
			];
			$this->template->set('title', 'Edit User');
			$this->template->load('main', 'contents', 'user/edit', $data);
		}
	}

	public function update()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required|max_length[255]');
		$this->form_validation->set_rules('username', 'Username', 'required|max_length[255]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		// $this->form_validation->set_rules('password', 'Password', 'required|max_length[255]');
		$this->form_validation->set_rules('level', 'Level', 'required|max_length[30]');
		$this->form_validation->set_rules('status', 'Status', 'required');

		if ($this->form_validation->run() == false) {
			$this->edit($this->input->post('id'));
		} else {
			$data = $this->input->post(null, true);
			$id = $data['id'];
			unset($data['id']);

			$update = $this->db->update('user', $data, ['id' => $id]);

			if ($update) {
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Berhasil diubah!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
				redirect('user');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Data gagal diubah!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
				redirect('user');
			}
		}
	}

	public function delete($id = '')
	{
		$delete = $this->db->get_where('user', ['id' => $id])->row_array();

		if ($delete) {
			$delete = $this->db->delete('user', ['id' => $id]);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Berhasil dihapus!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
			redirect('user');
		} else {
			show_404();
		}
	}

	public function aktif($id = '', $status = '')
	{
		$update = $this->db->get_where('user', ['id' => $id])->row_array();

		if ($update) {
			$this->db->update('user', ['status' => $status], ['id' => $id]);
			$status = $status == 1 ? 'diaktifkan' : 'dinon aktifkan';
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Berhasil ' . $status . '!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
			redirect('user');
		} else {
			show_404();
		}
	}
}
