   <div class="col s12 l9 m12 content">
      <?php
      //tampilkan pesan gagal
      if ($this->session->flashdata('alert'))
      {
         echo '<div class="alert alert-danger alert-message">';
         echo '<center>'.$this->session->flashdata('alert').'</center>';
         echo '</div>';
      }
      //tampilkan pesan success
      if ($this->session->flashdata('success'))
      {
         echo '<div class="alert alert-success alert-message">';
         echo '<center>'.$this->session->flashdata('success').'</center>';
         echo '</div>';
      }
      //tampilkan header pencarian
      if (isset($search) && $search != null)
      {
         echo '<h4>Hasil Pencarian dari "'.$search.'"</h4>';
      }
      //tampilkan header kategori
      if ($data->num_rows() > 0)
      {
         if (isset($url)) {
            echo '<h4>List Item Pada Kategori "'.$url.'"</h4><hr />';
         }
      ?>
      <div class="row">
         <?php
         if (isset($fav) && $fav->num_rows() > 0) {
            foreach ($fav->result() as $f) :
               $favorite[] = $f->id_item;
            endforeach;
         }
         ?>
         <?php foreach($data->result() as $key) : ?>
            <div class="col s12 m6 l3">
               <div class="card medium">
                  <div class="card-image">
                     <a href="<?= base_url('home/detail/'.$key->link); ?>">
                        <img src="<?= base_url('assets/upload/'.$key->gambar); ?>" class="responsive-img">
                     </a>
                  </div>
                  <span class="card-title"><?= $key->nama_item; ?>
                     <p> Rp. <?= number_format($key->harga, 0, ',', '.'); ?>,-</p>
                  </span>
                  
                  <div class="card-action center">
                     <form action="<?= base_url('cart/add/'.$key->link); ?>" method="post">
                        <div class="left">
                           <?php
                           if ($this->cart->contents())
                           {
                              foreach ($this->cart->contents() as $cart) {
                                 $stok = ($cart['id'] == $key->id_item) ? ($key->stok - $cart['qty']) : $key->stok;
                              }
                           } else {
                              $stok = $key->stok;
                           }

                           if ($stok > 1)
                           {
                              echo 'Stok : <span class="badge cyan white-text">'.$stok.'</span>';
                           } else {
                              echo 'Stok : <span class="badge red white-text">Habis</span>';
                           }
                           ?>
                        </div>
                        <input type="number" name="qty" value="1" min="1" max="<?= $key->stok; ?>" <?php if ($stok < 1) { echo 'disabled'; }?>>

                        <a href="<?= base_url('home/detail/'.$key->link); ?>" class="waves-effect waves-light btn black white-text tooltipped" data-position="bottom" data-delay="50" data-tooltip="Lihat Detail">
                           <i class="fa fa-search-plus"></i>
                        </a>

                        <button type="submit" class="waves-effect waves-light btn black white-text tooltipped" name="submit" value="Submit" <?php if ($key->stok < 1) { echo 'disabled'; } ?> data-position="bottom" data-delay="50" data-tooltip="Tambah ke Keranjang">
                           <i class="fa fa-shopping-cart"></i>
                        </button>
                       
                     </form>
                  </div>
               </div>
            </div>
         <?php endforeach; ?>
      </div>
      <?= $link; ?>
      <?php
      } else {
         if (isset($url)) {
            echo '<h5>Kategori "'.$url.'" Masih Kosong</h5><hr />';
         } else {
            echo '<h5>Item tidak ditemukan....</h5>';
         }
      }
      ?>
   </div>

