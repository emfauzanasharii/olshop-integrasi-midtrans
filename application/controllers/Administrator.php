<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'form_validation'));
		$this->load->model('admin');
	}

	public function index()
	{
		$this->cek_login();

		// $data['user'] = $this->admin->count('t_users');
		// $data['tag'] = $this->admin->count('t_kategori');
		// $data['item'] = $this->admin->count('t_items');
		// $data['trans'] = $this->admin->count_where('t_order', ['status_proses!=' => 'belum']);
		// $data['last'] = $this->admin->last('t_order', 3, 'tgl_pesan');
		redirect('item');
	}

	public function edit_profil()
	{
		$this->cek_login();

		if ($this->input->post('submit', TRUE) == 'Submit')
		{
			//validasi form
			$this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]');
			$this->form_validation->set_rules('fullname', 'Fullname', "required|trim|min_length[3]|regex_match[/^[a-z A-Z.']+$/]");
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$get_data = $this->admin->get_where('t_admin', array('id_admin' => $this->session->userdata('admin')))->row();

				if (!password_verify($this->input->post('password',TRUE), $get_data->password))
				{
					echo '<script type="text/javascript">alert("Password yang anda masukkan salah");window.location.replace("'.base_url().'login/logout")</script>';
				} else {

					$data = array(
						'username' => $this->input->post('username', TRUE),
						'fullname' => $this->input->post('fullname', TRUE),
						'email' => $this->input->post('email', TRUE),
					);

					$cond = array('id_admin' => $this->session->userdata('admin'));

					$this->admin->update('t_admin', $data, $cond);

					redirect('administrator');
				}
			}

		}

		$get = $this->admin->get_where('t_admin', array('id_admin' => $this->session->userdata('admin')))->row();

		$data['username'] = $get->username;
		$data['fullname'] = $get->fullname;
		$data['email'] 		= $get->email;

		$this->template->admin('admin/edit_profil', $data);
	}

	public function update_password()
	{
		$this->cek_login();

		if ($this->input->post('submit', TRUE) == 'Submit')
		{
			//validasi form

			$this->form_validation->set_rules('password1', 'Password Baru', 'required');
			$this->form_validation->set_rules('password2', 'Password Lama', 'required');

			if ($this->form_validation->run() == TRUE)
			{
				$get_data = $this->admin->get_where('t_admin', array('id_admin' => $this->session->userdata('admin')))->row();

				if (!password_verify($this->input->post('password2',TRUE), $get_data->password))
				{
					echo '<script type="text/javascript">alert("Password lama yang anda masukkan salah");window.location.replace("'.base_url().'login/logout")</script>';

				} else {

					$pass = $this->input->post('password1', TRUE);
					$data['password'] = password_hash($pass, PASSWORD_DEFAULT, ['cost' => 10]);
					$cond = array('id_admin' => $this->session->userdata('admin'));

					$this->admin->update('t_admin', $data, $cond);

					redirect('login/logout');
				}
			}
		}
		$this->template->admin('admin/update_pass');
	}

	public function report()
	{
		$data = $this->admin->report();

		foreach ($data->result() as $key) {
			echo ($key->total - $key->biaya);
		}
	}

	function cek_login()
	{
		if (!$this->session->userdata('admin'))
		{
			redirect('login');
		}
	}
}
