<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_access($this->uri->segment(1), $this->session->userdata('user'));
	}

	public function index()
	{
		$data = [
			'title'	=> 'Dashboard'
		];
		$this->template->set('title', 'Dashboard');
		$this->template->load('main', 'contents', 'dashboard/index', $data);
	}
}
