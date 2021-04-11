<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('template');
      $this->load->model('tags');
	}

   public function index()
	{
		$this->cek_login();

      $this->template->admin('admin/tag');
	}

   public function ajax_list()
   {
      $list = $this->tags->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $i) {
         $no++;
         $row = array();
         $row[] = $no;
         $row[] = $i->kategori;
         $row[] = $i->url;
         $row[] = '<a href="'.site_url('tag/del_tag/'.$i->id_kategori).'" class="btn btn-danger btn-xs" onclick="return confirm(\'Yakin ingin menghapus data ini?\')"><i class="fa fa-trash"></i></a>';

         $data[] = $row;
      }

      $output = array(
               	"draw" => $_POST['draw'],
               	"recordsTotal" => $this->tags->count_all(),
               	"recordsFiltered" => $this->tags->count_filtered(),
               	"data" => $data
      			);
      //output to json format
   	echo json_encode($output);
   }

	public function del_tag()
	{
		$this->cek_login();
		if(!is_numeric($this->uri->segment(3)))
		{
			redirect('tag');
		}

		$this->tags->delete(['t_kategori', 't_rkategori'], ['id_kategori' => $this->uri->segment(3)]);

		redirect('tag');
	}

   function cek_login()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect('login');
		}
	}
}
