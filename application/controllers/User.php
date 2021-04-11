<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('template');
      $this->load->model('users');
	}

   public function index()
   {
		$this->cek_login();

		$this->template->admin('admin/manage_user');
   }

	public function ajax_list()
  {
      $list = $this->users->get_datatables();
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $i) {

        if($i->status == 1) {
          $status = '<a href="'.site_url('user/status/2/'.$i->id_user).'" class="btn btn-success btn-xs">Active</a>';
        } else {
          $status = '<a href="'.site_url('user/status/1/'.$i->id_user).'" class="btn btn-danger btn-xs">Non Active</a>';
        }

        $no++;
        $row = array();
        $row[] = $no;
        $row[] = $i->fullname;
        $row[] = $i->alamat;
        $row[] = $i->telp;
        $row[] = $status;
        $row[] = '<a href="'.site_url('user/detail/'.$i->id_user).'" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i></a>';

        $data[] = $row;
      }

      $output = array(
               	"draw" => $_POST['draw'],
               	"recordsTotal" => $this->users->count_all(),
               	"recordsFiltered" => $this->users->count_filtered(),
               	"data" => $data
      			);
      //output to json format
   	echo json_encode($output);
  }

  public function status()
  {
    $this->cek_login();

    if (!is_numeric($this->uri->segment(3)) || !is_numeric($this->uri->segment(4)))
    {
      redirect('user');
    }

    $this->users->update('t_users', ['status' => $this->uri->segment(3)], ['id_user' => $this->uri->segment(4)]);

    redirect('user');
  }

  public function detail()
  {
    $this->cek_login();

    if (!is_numeric($this->uri->segment(3)))
    {
      redirect('user');
    }

    $data['data'] = $this->users->get_where('t_users',['id_user' => $this->uri->segment(3)]);

    $this->template->admin('admin/detail_user', $data);
  }

	function cek_login()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect('login');
		}
	}
}
