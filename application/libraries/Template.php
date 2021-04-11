<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template
{

   function __construct()
   {
      $this->ci =&get_instance();
   }

   function admin($template, $data_content = array())
   {
      $this->ci->load->model('admin');

      $data_content['profil']  = $this->ci->admin->get_all('t_profil');
      $data['content']         = $this->ci->load->view($template, $data_content, TRUE);
      $data['nav']             = $this->ci->load->view('admin/nav', $data_content, TRUE);

      $this->ci->load->view('admin/dashboard', $data);

   }

   function olshop($template, $data_content = array())
   {

      // var_dump($data_content);
      // die();
      $this->ci->load->model('app');

      $data_content['profil'] 	= $this->ci->app->get_all('t_profil');
      $data_content['kategori']  = $this->ci->app->get_all('t_kategori');
      $data['content']           = $this->ci->load->view($template, $data_content, TRUE);

      $this->ci->load->view('index', $data);

   }
}
