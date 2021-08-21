<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GeneratorData extends CI_Controller
{

	public function index()
	{
		$this->db->truncate('user');
		$this->db->truncate('barang');
		$this->db->truncate('transaksi');

		$data_user = [
			[
				'username'	=> 'james',
				'email'		=> 'james@gmail.com',
				'password'	=> password_hash('password', PASSWORD_DEFAULT),
				'nama'		=> 'James',
				'level'		=> 'karyawan'
			],
			[
				'username'	=> 'ayu',
				'email'		=> 'ayu@gmail.com',
				'password'	=> password_hash('password', PASSWORD_DEFAULT),
				'nama'		=> 'Ayu',
				'level'		=> 'karyawan'
			],
			[
				'username'	=> 'david',
				'email'		=> 'david@gmail.com',
				'password'	=> password_hash('password', PASSWORD_DEFAULT),
				'nama'		=> 'David',
				'level'		=> 'manager'
			]
		];

		$data_barang = [
			[
				'kode_barang'	=> 'BRG1/0821',
				'nama_barang'	=> 'Barang 1',
				'harga'			=> 100000,
				'stok'			=> 10
			],
			[
				'kode_barang'	=> 'BRG2/0821',
				'nama_barang'	=> 'Barang 2',
				'harga'			=> 100000,
				'stok'			=> 20
			],
			[
				'kode_barang'	=> 'BRG3/0821',
				'nama_barang'	=> 'Barang 3',
				'harga'			=> 300000,
				'stok'			=> 30
			]
		];

		$data_transaksi = [
			[
				'id_user'			=> 1,
				'kode_transaksi'	=> 'TRN01/0821',
				'tanggal'			=> date('Y-m-d'),
				'total'				=> 200000
			],
			[
				'id_user'			=> 1,
				'kode_transaksi'	=> 'TRN02/0821',
				'tanggal'			=> date('Y-m-d'),
				'total'				=> 300000
			],
			[
				'id_user'			=> 2,
				'kode_transaksi'	=> 'TRN03/0821',
				'tanggal'			=> '2021-07-01',
				'total'				=> 600000
			],
			[
				'id_user'			=> 2,
				'kode_transaksi'	=> 'TRN04/0821',
				'tanggal'			=> '2021-07-15',
				'total'				=> 800000
			],
		];

		$this->db->insert_batch('user', $data_user);
		$this->db->insert_batch('barang', $data_barang);
		$this->db->insert_batch('transaksi', $data_transaksi);

		echo 'berhasil';
	}
}
