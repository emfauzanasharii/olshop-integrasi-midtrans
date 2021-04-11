<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'cart'));
		$this->load->model('app');
	}

	public function index($offset=0)
	{
		$this->load->library('pagination');
      //configure
      $config['base_url'] = base_url().'home/index';
      $config['total_rows'] = $this->app->get_all('t_items')->num_rows();
      $config['per_page'] = 8;
      $config['uri_segment'] = 3;

      $this->pagination->initialize($config);

      $data['link']  = $this->pagination->create_links();

      $data['data'] 	 = $this->app->select_where_limit('t_items', ['aktif' => 1], $config['per_page'], $offset);
		$this->template->olshop('home', $data);

	}

	public function search()
	{
		if ($this->input->post('search', TRUE))
		{

			$this->session->set_userdata(['s' => $this->input->post('search', TRUE)]);
			$search = $this->session->userdata('s');

		} else {

			$search = $this->uri->segment(3);

		}

		if (!$this->uri->segment(4))
		{

			$offset = 0;

		} else {

			$offset = $this->uri->segment(4);

		}

		$this->load->library('pagination');
      //configure
      $config['base_url'] = base_url().'home/search/'.$search;
      $config['total_rows'] = $this->app->get_like('t_items', ['aktif' => 1], ['nama_item' => $search])->num_rows();
      $config['per_page'] = 6;
      $config['uri_segment'] = 4;

      $this->pagination->initialize($config);

      $data['link']  = $this->pagination->create_links();
      $data['data'] 	= $this->app->select_like('t_items', ['aktif' => 1], ['nama_item' => $search], $config['per_page'], $offset);
		$data['search'] = $search;
		$this->template->olshop('home', $data);

	}

	public function price()
	{

		if ($this->input->post('submit', TRUE) == 'Filter')
		{

			$this->session->set_userdata([
				'min' => $this->input->post('min', TRUE),
				'max' => $this->input->post('max', TRUE)
			]);

			$min = str_replace('.','',$this->session->userdata('min'));
			$max = str_replace('.','',$this->session->userdata('max'));

		} else {

			$min = $this->uri->segment(3);
			$max = $this->uri->segment(4);

		}

		if (!is_numeric($min) || !is_numeric($max))
		{

			redirect('home');

		}

		if (!$this->uri->segment(5))
		{

			$offset = 0;

		} else {

			$offset = $this->uri->segment(5);

		}

		$where = ['harga >=' => $min, 'harga <=' => $max, 'aktif' => 1];

		$this->load->library('pagination');
      //configure
      $config['base_url'] = base_url().'home/price/'.$min.'/'.$max;
      $config['total_rows'] = $this->app->get_where('t_items', $where)->num_rows();
      $config['per_page'] = 6;
      $config['uri_segment'] = 5;

      $this->pagination->initialize($config);

      $data['link']  = $this->pagination->create_links();
      $data['data'] 	= $this->app->select_where_limit('t_items', $where, $config['per_page'], $offset);
		$this->template->olshop('home', $data);

	}

	public function kategori()
	{

		if (!$this->uri->segment(3))
		{
			redirect('home');
		}

		$offset = (!$this->uri->segment(4)) ? 0 : $this->uri->segment(4);

		$url = strtolower(str_replace([' ','%20','_'], '-', $this->uri->segment(3)));

		$table = 't_kategori k
						JOIN t_rkategori rk ON (k.id_kategori = rk.id_kategori)
						JOIN t_items i ON (rk.id_item = i.id_item)';
		//load library pagination
		$this->load->library('pagination');
		//configure
		$config['base_url'] 		= base_url().'home/kategori/'.$this->uri->segment(3);
		$config['total_rows'] 	= $this->app->get_where($table, ['i.aktif' => 1, 'k.url' => $url])->num_rows();
		$config['per_page'] 		= 6;
		$config['uri_segment'] 	= 4;

		$this->pagination->initialize($config);

		$data['link']  = $this->pagination->create_links();
		$data['data'] 	= $this->app->select_where_limit($table, ['i.aktif' => 1, 'k.url' => $url], $config['per_page'], $offset);
		$data['url'] = ucwords(str_replace(['-','%20','_'], ' ', $this->uri->segment(3)));

		$this->template->olshop('home', $data);

	}

	public function detail()
	{

		if (is_numeric($this->uri->segment(3)))
		{

			$id = $this->uri->segment(3);

			$items = $this->app->get_where('t_items', array('link' => $id));
			$get = $items->row();

			$table = "t_rkategori rk
							JOIN t_kategori k ON (k.id_kategori = rk.id_kategori)";

			$data['kat'] 	= $this->app->get_where($table, array('rk.id_item' => $get->id_item));
			$data['data'] 	= $items;
			$data['img'] 	= $this->app->get_where('t_img', ['id_item' => $get->id_item]);

			$this->template->olshop('item_detail', $data);

		} else {

			redirect('home');

		}

	}





	

	

	

	public function transaksi()
	{

		if (!$this->session->userdata('user_id'))
		{
			redirect('home');
		}

		$table		 = "t_order o JOIN t_users u ON (o.email = u.email)";
		$data['get'] = $this->app->get_where($table, ['id_user' => $this->session->userdata('user_id')]);

		$this->template->olshop('transaksi', $data);

	}

	public function detail_transaksi()
	{

		if (!is_numeric($this->uri->segment(3)))
		{
			redirect('home');
		}

		$table = "t_order o
						JOIN t_detail_order do ON (o.id_order = do.id_order)
						JOIN t_items i ON (do.id_item = i.id_item)";

		$data['get'] = $this->app->get_where($table, ['o.id_order' => $this->uri->segment(3)]);

		$this->template->olshop('detail_transaksi', $data);

	}

	public function hapus_transaksi()
	{

		if (!is_numeric($this->uri->segment(3)))
		{
			redirect('home');
		}
		//kembalikan stok
		$table 	= 't_detail_order do
							JOIN t_items i ON (do.id_item = i.id_item)';
		$get 		= $this->app->get_where($table, ['id_order' => $this->uri->segment(3)]);

		foreach ($get->result() as $key) {
			//jumlahkan stok
			$stok = ($key->qty + $key->stok);
			//update stok
			$this->app->update('t_items', ['stok' => $stok], ['id_item' => $key->id_item]);
		}

		$tables = array('t_order', 't_detail_order');
		$this->app->delete($tables, ['id_order' => $this->uri->segment(3)]);

		redirect('home/transaksi');

	}

	public function transaksi_selesai()
	{

		if (!is_numeric($this->uri->segment(3)))
		{
			redirect('home');
		}

		$this->app->update('t_order', ['status_proses' => 'selesai'], ['id_order' => $this->uri->segment(3)]);

		redirect('home/transaksi');

	}

	
}
