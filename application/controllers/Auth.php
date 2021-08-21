<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('auth_model', 'auth');
	}

	public function index()
	{
		$this->_logged_in();
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == false) {
			$this->load->view('auth/login.php');
		} else {
			$user = $this->db->get_where('user', ['username' => $username])->row_array();

			// cek user
			if ($user) {
				// jika ada
				// cek password
				if (password_verify($password, $user['password'])) {
					// jika passwordnya cocok
					$data = [
						'user'		=> $user,
						'is_loggin'	=> true
					];

					$this->session->set_userdata($data);
					redirect('dashboard');
				} else {
					// jika password salah
					$this->session->set_flashdata('message', 'Password salah!!');
					redirect('auth');
				}
			} else {
				// jika tidak ada
				$this->session->set_flashdata('message', 'Username tidak terdaftar!!');
				redirect('auth');
			}
		}
	}


	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth');
	}

	private function _logged_in()
	{
		if ($this->session->userdata('user')) {
			redirect('dashboard');
		}
	}
}
