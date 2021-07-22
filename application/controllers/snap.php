<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Snap extends CI_Controller {


	public function __construct()
    {
        parent::__construct();
        $params = array('server_key' => 'SB-Mid-server-Idk3sx75mAwC0OidE1p_A8sx', 'production' => false);
		// $this->load->library('midtrans','cart');
		$this->load->library(array('midtrans', 'cart'));
		$this->midtrans->config($params);
		$this->load->helper('url');	
		$this->load->model('app');
    }

    public function index()
    {
    	$this->load->view('checkout_snap');
    }
public function cek(){
	$nama=$this->input->post('nama');
    	// $nama_belakang=$this->input->post('nama_belakang');
    	$t=$this->input->post('total');
    	$total=intval($t);
    	var_dump($total);
    	die();
}
    public function token()
    {
    	$nama=$this->input->post('nama');
    	// $nama_belakang=$this->input->post('nama_belakang');
    	$total=$this->input->post('total');
    	$o=str_replace(".","",$this->input->post('ongkir'));
    	$ongkir=intval($o);
    	$alamat=$this->input->post('alamat');
    	$nama_belakang=$this->input->post('nama_belakang');
    	$email=$this->input->post('email');
    	$kurir=$this->input->post('kurir');
    	$layanan=$this->input->post('layanan');
    	$p = explode(",", $this->input->post('prov', TRUE));
    	$prov=$p[1];
    	$k = explode(",", $this->input->post('kota', TRUE));
    	$prov=$this->input->post('prov');
    	$kab=$k[1];
    	$kd_pos=$this->input->post('pos');
    	$subtotal=$this->cart->total();
    	$total_bayar=$subtotal+$ongkir;
    	// var_dump($total);
    	// die();
		
		// Required
		$transaction_details = array(
		  'order_id' => rand(),
		  'gross_amount' => $subtotal+$ongkir, // no decimal allowed for creditcard
		);

			foreach ($this->cart->contents() as $key) {
				$item1_details[] = array(
		 'id' => $key['id'],
		'price' => $key['price'],
		'quantity' => $key['qty'],
		'name' => $key['name']);
	 	};


		// // Optional
		$item_details = array ($item1_details,$item2_details);

		// Optional
		$billing_address = array(
		  'first_name'    => $nama,
		  'last_name'     => $nama_belakang,
		  'address'       => $alamat,
		  'city'          => $kab,
		  'postal_code'   => $kd_pos,
		  'phone'         => "081122334455",
		  'country_code'  => 'IDN'
		);

		// Optional
		$shipping_address = array(
		  'first_name'    => $nama,
		  'last_name'     => $nama_belakang,
		  'address'       => $alamat,
		  'city'          => $kab,
		  'postal_code'   => $kd_pos,
		  'phone'         => "08113366345",
		  'country_code'  => 'IDN'
		);

		// Optional
		$customer_details = array(
		  'first_name'    => $nama,
		  'last_name'     => $nama_belakang,
		  'email'         => $email,
		  'phone'         => "081122334455",
		  'billing_address'  => $billing_address,
		  'shipping_address' => $shipping_address
		);

		// Data yang akan dikirim untuk request redirect_url.
        $credit_card['secure'] = true;
        //ser save_card true to enable oneclick or 2click
        //$credit_card['save_card'] = true;

        $time = time();
        $custom_expiry = array(
            'start_time' => date("Y-m-d H:i:s O",$time),
            'unit' => 'minute', 
            'duration'  => 2
        );
        
        $transaction_data = array(
            'transaction_details'=> $transaction_details,
            'item_details'       => $item_details,
            'customer_details'   => $customer_details,
            'credit_card'        => $credit_card,
            'expiry'             => $custom_expiry
        );

		error_log(json_encode($transaction_data));
		$snapToken = $this->midtrans->getSnapToken($transaction_data);
		error_log($snapToken);
		echo $snapToken;
    }

    public function finish()
    {
    	$result = json_decode($this->input->post('result_data'));

					$nama_pemesan = $this->input->post('first_name', TRUE).' '.$this->input->post('last_name', TRUE);
					$email = $this->input->post('user_mail', TRUE);

				$profil 	= $this->app->get_where('t_profil', ['id_profil' => 1])->row();

				$this->load->library('mailer');

        		$id_order 	= $result->order_id;
				$kota 		= explode(",", $this->input->post('kota', TRUE));
				$alamat 	= $this->input->post('alamat', TRUE);
				$pos 		= $this->input->post('kd_pos', TRUE);
				$kurir 		= $this->input->post('kurir', TRUE);
				$layanan 	= explode(",", $this->input->post('layanan', TRUE));
				$ongkir 	= $layanan[0];
				$total 		= ($layanan[0] + $this->cart->total());
				$tgl_pesan 	= date("Y-m-d");
				$bts 		= date("Y-m-d", mktime(0,0,0, date("m"), date("d") + 3, date("Y")));
				$bts_bayar	= date('d-m-Y', strtotime($bts));

				$table = '';
				$no = 1;
				foreach ($this->cart->contents() as $carts) {
					$table .= '<tr><td>'.$no++.'</td><td>'.$carts['name'].'</td><td>'.$carts['qty'].'</td><td style="text-align:right">'.number_format($carts['subtotal'], 0, ',', '.').'</td></tr>';
				}
				 
        	$pesan='Terima Kasih telah melakukan pemesanan di toko kami, selanjutnya silahkan anda mentransfer uang senilai <b>Rp. '.number_format($total, 0, ',', '.').',-</b> Bill Key anda <b>' .$result->bill_key.'</b> segera lakukan pembayaran sebelum tanggal '.$bts_bayar.' agar pesanan anda bisa kami proses. Detail pembayaran sebagai berikut :<br/><br/>
					Id Order : '.$result->order_id.'<br/><br/>
					<table border="1" style="width: 80%">
						<tr><th>#</th><th>Nama Barang</th><th>Jumlah</th><th>Harga</th></tr>
						'.$table.'
						<tr><td colspan="3">Ongkos Kirim</td><td style="text-align:right">'.number_format($ongkir, 0, ',', '.').'</td></tr>
						<tr><td colspan="3">Total</td><td style="text-align:right">'.number_format($total, 0, ',', '.').'</td></tr>
					</table>
					';
				$email_penerima =  $email;
				$subjek = "Pembayaran";
				 $sendmail = array(
								      'email_penerima'=>$email_penerima,
								      'subjek'=>$subjek,
								      'content'=>$pesan 
								    );
          if ($this->mailer->send($sendmail))
          {
            	$data = array(
						'id_order' 		=> $result->order_id,
						'nama_pemesan' 	=> $nama_pemesan,
						'email' 		=> $email,
						'total' 		=> $total,
						'tujuan' 		=> $alamat,
						'pos' 			=> $pos,
						'kota' 			=> $kota[1],
						'kurir' 		=> $kurir,
						'service' 		=> $layanan[1],
						'tgl_pesan' 	=> $tgl_pesan,
						'bts_bayar' 	=> $bts,
						'status_proses'	=> $result->status_message
						
					);

				if ($this->app->insert('t_order', $data)) {

					foreach ($this->cart->contents() as $key) {
						$detail = [
									'id_order' 	=> $result->order_id,
									'id_item' 	=> $key['id'],
									'qty' 		=> $key['qty'],
									'biaya' 		=> $key['subtotal']
								];
						$this->app->insert('t_detail_order', $detail);
					}

					$this->cart->destroy();
    	

    }
}
redirect(base_url().'home');
}
}
