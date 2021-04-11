<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'form_validation'));
		$this->load->model('admin');
	}

	public function index()
	{
		$this->cek_login();

      if ($this->input->post('submit', TRUE))
      {
        //validasi
        $this->form_validation->set_rules('title', 'Title', 'required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('hp', 'Phone', 'required|min_length[5]|max_length[15]|numeric');
        $this->form_validation->set_rules('fb', 'Facebook', 'required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('twitter', 'Twitter', 'required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('gplus', 'G+', 'required|min_length[5]|max_length[255]');
        $this->form_validation->set_rules('alamat', 'Alamat Toko', 'required|min_length[5]');
				$this->form_validation->set_rules('email_toko', 'Email Toko', 'required|valid_email');
				$this->form_validation->set_rules('pass_toko', 'Password Email Toko', 'required|min_length[5]');
				$this->form_validation->set_rules('asal', 'ID Kota / Kabupaten', 'required|max_length[3]|numeric');
				$this->form_validation->set_rules('api_key', 'Api Key', 'required|min_length[5]');
				$this->form_validation->set_rules('rekening', 'Rekening', 'required|min_length[8]');

        if ($this->form_validation->run() == TRUE)
        {
          $profile = array(
              'title' => $this->input->post('title', TRUE),
              'phone' => $this->input->post('hp', TRUE),
              'alamat_toko' => $this->input->post('alamat', TRUE),
              'facebook' => $this->input->post('fb', TRUE),
              'twitter' => $this->input->post('twitter', TRUE),
              'gplus' => $this->input->post('gplus', TRUE),
							'email_toko' => $this->input->post('email_toko', TRUE),
							'pass_toko' => $this->input->post('pass_toko', TRUE),
							'asal' => $this->input->post('asal', TRUE),
							'api_key' => $this->input->post('api_key', TRUE),
							'rekening' => $this->input->post('rekening', TRUE)
          );

          $this->admin->update('t_profil', $profile, ['id_profil' => 1]);

          redirect('setting');
        }

        $data['judul']    	= $this->input->post('title', TRUE);
        $data['alamat']   	= $this->input->post('alamat', TRUE);
        $data['hp']       	= $this->input->post('hp', TRUE);
        $data['fb']       	= $this->input->post('fb', TRUE);
        $data['twitter']  	= $this->input->post('twitter', TRUE);
        $data['gplus']    	= $this->input->post('gplus', TRUE);
				$data['mail_toko']   = $this->input->post('email_toko', TRUE);
				$data['pass_toko']   = $this->input->post('pass_toko', TRUE);
				$data['api_key']    	= $this->input->post('api_key', TRUE);
				$data['asal']  	  	= $this->input->post('asal', TRUE);
				$data['rekening']  	= $this->input->post('rekening', TRUE);

      } else {

        $profil = $this->admin->get_all('t_profil')->row();

        $data['judul']    	= $profil->title;
        $data['alamat']   	= $profil->alamat_toko;
        $data['hp']       	= str_replace('-', '',$profil->phone);
        $data['fb']       	= $profil->facebook;
        $data['twitter']  	= $profil->twitter;
        $data['gplus']    	= $profil->gplus;
				$data['mail_toko']   = $profil->email_toko;
				$data['pass_toko']   = $profil->pass_toko;
				$data['api_key']    	= $profil->api_key;
				$data['asal']	    	= $profil->asal;
				$data['rekening']    = $profil->rekening;
      }

		$this->template->admin('admin/setting', $data);
	}

	function cek_login()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect('login');
		}
	}
}
