<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'form_validation'));
      $this->load->model('items');
	}

   public function index()
   {
		$this->cek_login();

		$this->template->admin('admin/manage_item');
   }

	public function ajax_list()
   {
      $list = $this->items->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $i) {
			$status = ($i->aktif == 1) ? "Dijual" : 'Tidak Dijual';
         $no++;
         $row = array();
         $row[] = $no;
         $row[] = $i->nama_item;
         $row[] = $i->harga;
         $row[] = $status;
         $row[] = $i->stok;
         $row[] = '<a href="'.site_url('item/detail/'.$i->id_item).'" class="btn btn-success btn-xs"><i class="fa fa-search-plus"></i></a>
				<a href="'.site_url('item/update_item/'.$i->id_item).'" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>';

         $data[] = $row;
      }

      $output = array(
               	"draw" => $_POST['draw'],
               	"recordsTotal" => $this->items->count_all(),
               	"recordsFiltered" => $this->items->count_filtered(),
               	"data" => $data
      			);
      //output to json format
   	echo json_encode($output);
   }


   public function add_item()
   {
		$this->cek_login();

      if ($this->input->post('submit', TRUE) == 'Submit') {
         //validasi
         $this->form_validation->set_rules('nama', 'Nama Item', 'required|min_length[4]');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required|min_length[4]');
         $this->form_validation->set_rules('harga', 'Harga Item', 'required|numeric');
			$this->form_validation->set_rules('stok', 'Stok Item', 'required|numeric');
         $this->form_validation->set_rules('berat', 'Berat Item', 'required|numeric');
         $this->form_validation->set_rules('status', 'Status', 'required|numeric');
         $this->form_validation->set_rules('desk', 'Deskripsi', 'required|min_length[4]');

         if ($this->form_validation->run() == TRUE)
         {
				$config['upload_path'] = './assets/upload/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['file_name'] = 'gambar'.time();

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('foto'))
				{
					$gbr = $this->upload->data();
					//proses insert data item
		         	$items = array (
						'link' => time(),
						'nama_item' => $this->input->post('nama', TRUE),
						'harga' => $this->input->post('harga', TRUE),
						'berat' => $this->input->post('berat', TRUE),
						'stok' => $this->input->post('stok', TRUE),
		            	'aktif' => $this->input->post('status', TRUE),
						'gambar' => $gbr['file_name'],
		            	'deskripsi' => $this->input->post('desk', TRUE)
		         	);

		        	$id_item = $this->items->insert_last('t_items', $items);
					//akses function kategori
					$this->kategori($id_item, $this->input->post('kategori', TRUE));
					//upload Foto Lainnya
					$len = count($_FILES['gb']['name']); //hitung jumlah form

					for ($i=0; $i < $len; $i++) {
						$foto = '';
						//masukkan data file ke variabel foto sesuai index array
						$_FILES[$foto]['name'] = $_FILES['gb']['name'][$i];
				      	$_FILES[$foto]['type'] = $_FILES['gb']['type'][$i];
				      	$_FILES[$foto]['tmp_name'] = $_FILES['gb']['tmp_name'][$i];
						$_FILES[$foto]['size'] = $_FILES['gb']['size'][$i];
						$_FILES[$foto]['error'] = $_FILES['gb']['error'][$i];

						$config['file_name'] = 'img'.time().$i; //rename foto yang diupload

						$this->upload->initialize($config);

						if ($this->upload->do_upload($foto))
						{
							//fetch data file yang diupload
							$gb = $this->upload->data();

							$data = [
								'id_item' => $id_item,
								'img' => $gb['file_name']
							];
							//insert data img
							$this->items->insert('t_img', $data);
						}
			      }

					redirect('item');

				} else {
					$this->session->set_flashdata('alert', 'anda belum memilih foto');
				}
         }
      }

		$data['kategori'] 	= $this->input->post('kategori', TRUE);
		$data['kat'] 		= $this->items->get_all('t_kategori');
		$data['nama'] 		= $this->input->post('nama', TRUE);
		$data['berat'] 		= $this->input->post('berat', TRUE);
		$data['harga'] 		= $this->input->post('harga', TRUE);
		$data['status'] 	= $this->input->post('status', TRUE);
		$data['desk'] 		= $this->input->post('desk', TRUE);
		$data['stok'] 		= $this->input->post('stok', TRUE);
		$data['rk'] 		= '';

      $data['header'] = "Add New Item";

      $this->template->admin('admin/item_form', $data);
   }

	public function detail()
	{
		$this->cek_login();
		$id_item = $this->uri->segment(3);
		$item = $this->items->get_where('t_items', array('id_item' => $id_item));

		foreach ($item->result() as $key) {
			$data['id_item'] = $key->id_item;
			$data['nama_item'] = $key->nama_item;
			$data['harga'] = $key->harga;
			$data['berat'] = $key->berat;
			$data['status'] = $key->aktif;
			$data['stok'] = $key->stok;
			$data['gambar'] = $key->gambar;
			$data['deskripsi'] = $key->deskripsi;
		}

		$table = "t_rkategori rk
						JOIN t_kategori k ON (rk.id_kategori = k.id_kategori)";
		$data['kategori'] = $this->items->get_where($table, ['rk.id_item' => $id_item]);
		//ambil data img berdasarkan id_item
		$data['img'] = $this->items->get_where('t_img', ['id_item' => $id_item]);

		$this->template->admin('admin/detail_item', $data);
	}

	public function update_item()
   {
		$this->cek_login();
		$id_item = $this->uri->segment(3);

      if ($this->input->post('submit', TRUE) == 'Submit') {
         //validasi
         $this->form_validation->set_rules('nama', 'Nama Item', 'required|min_length[4]');
			$this->form_validation->set_rules('kategori', 'Kategori', 'required|min_length[4]');
         $this->form_validation->set_rules('harga', 'Harga Item', 'required|numeric');
			$this->form_validation->set_rules('stok', 'Stok Item', 'required|numeric');
         $this->form_validation->set_rules('berat', 'Berat Item', 'required|numeric');
         $this->form_validation->set_rules('status', 'Status', 'required|numeric');
         $this->form_validation->set_rules('desk', 'Deskripsi', 'required|min_length[4]');

         if ($this->form_validation->run() == TRUE)
         {
				$config['upload_path'] = './assets/upload/';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size'] = '2048';
				$config['file_name'] = 'gambar'.time();

				$this->load->library('upload', $config);

				$items = array (
					'nama_item' => $this->input->post('nama', TRUE),
					'harga' => $this->input->post('harga', TRUE),
					'berat' => $this->input->post('berat', TRUE),
					'stok' => $this->input->post('stok', TRUE),
					'aktif' => $this->input->post('status', TRUE),
					'deskripsi' => $this->input->post('desk', TRUE)
				);

				if ($this->upload->do_upload('foto'))
				{
					//fetch data file yang diupload
					$gbr = $this->upload->data();
					//hapus file img dari folder
					unlink('assets/upload/'.$this->input->post('old_pict', TRUE));
					$items['gambar'] = $gbr['file_name'];

		         $this->items->update('t_items', $items, array('id_item' => $id_item));
				} else {
					$this->items->update('t_items', $items, array('id_item' => $id_item));
				}

				$this->items->delete('t_rkategori', ['id_item' => $id_item]);
				$this->kategori($id_item, $this->input->post('kategori', TRUE));

				$len = count($_FILES['gb']['name']); //hitung jumlah form

				for ($i=0; $i < $len; $i++) {
					$foto = '';
					//masukkan data file ke variabel foto sesuai index array
					$_FILES[$foto]['name'] = $_FILES['gb']['name'][$i];
					$_FILES[$foto]['type'] = $_FILES['gb']['type'][$i];
					$_FILES[$foto]['tmp_name'] = $_FILES['gb']['tmp_name'][$i];
					$_FILES[$foto]['size'] = $_FILES['gb']['size'][$i];
					$_FILES[$foto]['error'] = $_FILES['gb']['error'][$i];

					$config['file_name'] = 'img'.time().$i; //rename foto yang diupload

					$this->upload->initialize($config);

					if ($this->upload->do_upload($foto))
					{
						$gb = $this->upload->data();

						$data = [
							'id_item' => $id_item,
							'img' => $gb['file_name']
						];

						$this->items->insert('t_img', $data);
					}
				}

				redirect('item');
         }
      }

		$item = $this->items->get_where('t_items', array('id_item' => $id_item));

		$table = "t_rkategori rk
						JOIN t_kategori k ON (rk.id_kategori = k.id_kategori)";
		$rk = $this->items->get_where($table, ['rk.id_item' => $id_item]);

		$value = '';
		foreach ($rk->result() as $k) {
			$value .= ', '.$k->kategori;
		}

		foreach($item->result() as $key) {
			$data['nama'] 	= $key->nama_item;
			$data['berat'] 	= $key->berat;
			$data['harga'] 	= $key->harga;
			$data['status'] = $key->aktif;
			$data['desk'] 	= $key->deskripsi;
			$data['gambar'] = $key->gambar;
			$data['stok'] 	= $key->stok;
		}

		$data['kat'] = $this->items->get_all('t_kategori');
		$data['kategori'] = trim($value, ', ');
		$data['rk'] = $rk;
		//ambil data file img berdasarkan id_item
		$gb = $this->items->get_where('t_img', ['id_item' => $id_item]);
		//cek data img
		if ($gb->num_rows() != 0)
		{
			$data['gb'] = $gb;
		} else {
			$data['gb'] = null;
		}

      $data['header'] = "Update Data Item";

      $this->template->admin('admin/item_form', $data);
   }

	private function kategori($id_item, $kategori)
	{
		$kat 	= explode(", ", $kategori);
		$len 	= count($kat);
		$a 		= array(' ');
		$b 		= array ('`','~','!','@','#','$','%','^','&','*','(',')','_','+','=','[',']','{','}','\'','"',':',';','/','\\','?','/','<','>');

		for ($i = 0; $i  < $len; $i ++) {
			$url = str_replace($b, '', $kat[$i]);
			$url = str_replace($a, '-', strtolower($url));

			$cek = $this->items->get_where('t_kategori', ['url' => $url]);

			if ($cek->num_rows() > 0) {

				$get = $cek->row();
				$id = $get->id_kategori;

			} else {

				$data = array(
					'kategori' => ucwords(trim($kat[$i])),
					'url' => $url
				);

				$id = $this->items->insert_last('t_kategori', $data);
			}

			$cek2 = $this->items->get_where('t_rkategori', ['id_item' => $id_item, 'id_kategori' => $id]);

			if ($cek2->num_rows() < 1) {
				$this->items->insert('t_rkategori', ['id_item' => $id_item, 'id_kategori' => $id]);
			}
		}
	}

	public function del_img()
	{
		$this->cek_login();
		if (!$this->uri->segment(3))
		{
			redirect('item');
		}
		//hapus file image dari folder
		unlink('assets/upload/'.$this->uri->segment(3));
		//hapus data yang ada pada database
		$this->items->delete('t_img', ['img' => $this->uri->segment(3)]);

		echo '<script type="text/javascript">window.history.go(-1)</script>';
	}

	public function update_img()
	{
		$this->cek_login();
		if (!$this->uri->segment(3))
		{
			redirect('item');
		}

		if ($this->input->post('submit', TRUE) == 'Submit')
		{
			$config['upload_path'] = './assets/upload/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size'] = '2048';
			$config['file_name'] = 'img'.time();

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('img'))
			{
				//hapus file image
				unlink('assets/upload/'.$this->uri->segment(3));

				$gbr = $this->upload->data();
				//proses update Database
				$this->items->update('t_img', ['img' => $gbr['file_name']], ['img' => $this->uri->segment(3)]);

				echo '<script type="text/javascript">window.history.go(-2)</script>';
			} else {
				$this->session->set_flashdata('alert', 'anda belum memilih foto');
			}
		}

		$this->template->admin('admin/up_img');
	}

	function cek_login()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect('login');
		}
	}
}
