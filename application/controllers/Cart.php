<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('template', 'cart'));
		$this->load->model('app');
	}

	public function index()
	{
      $this->template->olshop('cart');
	}

	public function add()
	{
		if (is_numeric($this->uri->segment(3)))
		{
			$id 	= $this->uri->segment(3);
			$get 	= $this->app->get_where('t_items', array('link' => $id))->row();

			if ($this->input->post('submit', TRUE) == 'Submit')
			{

				$qty 	= $this->input->post('qty', TRUE);

				if (!is_numeric($qty) || $qty < 1 || $qty > $get->stok)
				{

					$this->session->set_flashdata('alert', 'Submit tidak valid');

					redirect('home');

				}

				$special_char = ['`','~','!','@','#','$','%','^','&','*','(',')','_','-','+','=','[',']','{','}','\'','|','"',':',';','/','\\','?','/','<','>',','];
				//clean item name
				$name = str_replace($special_char, '', $get->nama_item);

	         $data = array(
	            'id'		=> $get->id_item,
					'link' 	=> $get->link,
	            'name' 	=> $name,
	            'price'	=> $get->harga,
	            'weight' => $get->berat,
	            'qty' 	=> $qty
	         );
				//insert cart
	         $this->cart->insert($data);

				$this->session->set_flashdata('success', 'Item telah ditambahkan ke keranjang');

	         echo '<script type="text/javascript">window.history.go(-1);</script>';
			}

		} else {
			redirect('home');
		}
	}

   public function update()
   {
      if ($this->uri->segment(3))
      {
         $this->load->library('form_validation');

         $this->form_validation->set_rules('qty', 'Jumlah Pesanan', 'required|numeric');

         if ($this->form_validation->run() == TRUE)
         {
				//ambil data cart
				foreach($this->cart->contents() as $c)
				{
					if ($c['rowid'] == $this->uri->segment(3))
					{
						$quantity = $c['qty'];
						$id		 = $c['id'];
					}
				}

				//ambil stok terkini
				$get = $this->app->get_where('t_items', ['id_item' => $id])->row();

				$stok = ($get->stok + $quantity);

				if ($this->input->post('qty', TRUE) > $stok)
				{
					$this->session->set_flashdata('alert', 'Submit tidak valid');

					redirect('home');
				}

            $data = array(
               'qty' 	=> $this->input->post('qty', TRUE),
               'rowid'	=> $this->uri->segment(3)
            );

            $this->cart->update($data);

				$this->session->set_flashdata('success', 'Item telah diupdate');

            redirect('cart');
         } else {

            $this->template->olshop('cart');
         }

      } else {
			$this->session->set_flashdata('alert', 'Item gagal diupdate');

         redirect('cart');
      }
   }

   public function delete()
   {
      if ($this->uri->segment(3))
      {

         $rowid = $this->uri->segment(3);

         $this->cart->remove($rowid);

			$this->session->set_flashdata('success', 'Item berhasil dihapus');

         redirect('cart');

      } else {

			$this->session->set_flashdata('alert', 'Item gagal dihapus');

         redirect('cart');
      }
   }
}
