<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h4><i class="fa fa-search-plus"></i> Detail Item</h4>
<hr />
<br />
<?php
$key = $data->row();
?>

<div class="row">
   <div class="col l5 m12 s12 offset-l1">
      <!-- Gambar Item -->
      <div class="product-image">
         <img id="myimg" src="<?= base_url('assets/upload/'.$key->gambar); ?>" alt="<?= $key->gambar; ?>" class="img-responsive">
      </div>
      <div class="product_gallery">
         <a onclick="document.getElementById('myimg').src='<?= base_url('assets/upload/'.$key->gambar); ?>'">
            <img src="<?= base_url('assets/upload/'.$key->gambar); ?>">
         </a>
         <?php foreach ($img->result() as $img): ?>
            <a onclick="document.getElementById('myimg').src='<?= base_url('assets/upload/'.$img->img); ?>'">
               <img src="<?= base_url('assets/upload/'.$img->img); ?>">
            </a>
         <?php endforeach; ?>
      </div>
   </div>
   <div class="col l4 m12 s12 offset-l1 detail">
      <!-- Detail Item -->
      <div class="item-title">
         <h4><?= ucfirst($key->nama_item); ?></h4>
      </div>
      <span>
         <i class="fa fa-tags"></i>
         <?php
         $val = '';
         foreach ($kat->result() as $value) {
            $val .= ', <a href="'.site_url('home/kategori/'.$value->url).'">'.$value->kategori.'</a>';
         }

         echo trim($val, ', ');
         ?>
      </span>
      <br />
      <p><?= ucfirst(nl2br($key->deskripsi)); ?></p>
      <span class="sub">Berat</span>
      <p><?= number_format($key->berat, 0, ',', '.').' gr'; ?></p>
      <div class="left">
         <?php if ($key->stok >= 10)
         {
            echo '<strong>Stok :</strong> <span class="badge green white-text">'.$key->stok.'</span>';
         } elseif ($key->stok < 10 && $key->stok > 0) {
            echo '<strong>Stok :</strong> <span class="badge orange white-text">'.$key->stok.'</span>';
         } else {
            echo '<strong>Stok :</strong> <span class="badge red white-text">Stok Habis</span>';
         }
         ?>
      </div>
      <div class="clearfix"></div>
      <div class="price">
         <?= 'IDR. '.number_format($key->harga, 0, ',', '.').',-'; ?>
      </div>

      <form action="<?= site_url('cart/add/'.$key->link); ?>" method="post" class="detail-item">

         <label>Jumlah Pesan</label>
         <input type="number" name="qty" min="1" max="<?=$key->stok;?>" value="1" <?php if($key->stok < 1) { echo 'disabled'; } ?>>

         <button type="submit" name="submit" value="Submit" class="btn blue waves-effect waves-light" <?php if($key->stok < 1) { echo 'disabled'; } ?>><i class="fa fa-shopping-cart"></i> Add to Cart</button>

         <button type="button" class="btn red waves-effect waves-light" onclick="window.history.go(-1)">Kembali</button>

      </form>
   </div>
</div>
