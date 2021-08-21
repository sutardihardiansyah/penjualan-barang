<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('barang_model', 'barang');
		is_access($this->uri->segment(1), $this->session->userdata('user'));
	}

	public function index()
	{
		if ($this->session->userdata('user')['level'] == 'karyawan') {
			$total 	  	= $this->db->select_sum('total')->where('id_user', $this->session->userdata('user')['id'])->get('transaksi')->row_array();
			$this->db->select('*');
			$this->db->from('transaksi');
			$this->db->join('user', 'user.id = transaksi.id_user');
			$this->db->where('id_user', $this->session->userdata('user')['id']);
			$transaksi = $this->db->get()->result_array();
		} else {
			$total 	  	= $this->db->select_sum('total')->get('transaksi')->row_array();
			$this->db->select('*');
			$this->db->from('transaksi');
			$this->db->join('user', 'user.id = transaksi.id_user');
			$transaksi = $this->db->get()->result_array();
		}

		$data = [
			'title'		=> 'Laporan Transaksi',
			'transaksi'	=> $transaksi,
			'total'		=> $total
		];
		$this->template->set('title', 'Laporan Transaksi');
		$this->template->load('main', 'contents', 'laporan/transaksi/index', $data);
	}

	public function export_excel()
	{
		// Load plugin PHPExcel nya
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

		// Panggil class PHPExcel nya
		$excel = new PHPExcel();

		// Settingan awal fil excel
		$excel->getProperties()->setCreator($this->session->userdata('user')['nama'])
			->setLastModifiedBy($this->session->userdata('user')['nama'])
			->setTitle("Laporan Data Transaksi")
			->setSubject("Laporan Data Transaksi")
			->setDescription("Laporan Data Transaksi")
			->setKeywords("Laporan Data Transaksi");
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);
		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Laporan Data Transaksi"); // Set kolom A1 dengan tulisan "Laporan Data Transaksi"
		$excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
		// Buat header tabel nya pada baris ke 3
		$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Kode Transaksi"); // Set kolom B3 dengan tulisan "Kode Transaksi"
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "Nama User"); // Set kolom C3 dengan tulisan "Nama user"
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "Nama Customer"); // Set kolom C3 dengan tulisan "Nama user"
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "Tanggal"); // Set kolom D3 dengan tulisan "Tanggal"
		$excel->setActiveSheetIndex(0)->setCellValue('F3', "Total"); // Set kolom E3 dengan tulisan "Total"

		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);

		if ($this->session->userdata('user')['level'] == 'karyawan') {
			$total 	  	= $this->db->select_sum('total')->where('id_user', $this->session->userdata('user')['id'])->get('transaksi')->row_array();
			$this->db->select('*');
			$this->db->from('transaksi');
			$this->db->join('user', 'user.id = transaksi.id_user');
			$this->db->where('id_user', $this->session->userdata('user')['id']);
			$transaksi = $this->db->get()->result_array();
		} else {
			$total 	  	= $this->db->select_sum('total')->get('transaksi')->row_array();
			$this->db->select('*');
			$this->db->from('transaksi');
			$this->db->join('user', 'user.id = transaksi.id_user');
			$transaksi = $this->db->get()->result_array();
		}


		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
		$colTotal = count($transaksi) + $numrow + 1;
		foreach ($transaksi as $data) { // Lakukan looping pada variabel siswa
			$excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $no);
			$excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $data['kode_transaksi']);
			$excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data['nama']);
			$excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data['nama_customer'] ? $data['nama_customer'] : '-');
			$excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data['tanggal']);
			$excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, 'Rp. ' . number_format($data['total'], 0, '.', '.'));

			// Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
			$excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);

			$no++; // Tambah 1 setiap kali looping
			$numrow++; // Tambah 1 setiap kali looping
		}
		$excel->setActiveSheetIndex(0)->setCellValue('E' . $colTotal, "Total"); // Set kolom A1 dengan tulisan "Laporan Data Transaksi"
		$excel->setActiveSheetIndex(0)->setCellValue('F' . $colTotal, 'Rp. ' . number_format($total['total'], 0, '.', '.')); // Set kolom A1 dengan tulisan "Laporan Data Transaksi"

		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); // Set width kolom C
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom D
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom E

		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$excel->getActiveSheet(0)->setTitle("Laporan Data Transaksi");
		$excel->setActiveSheetIndex(0);
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Data Transaksi.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		$write->save('php://output');
	}
}
