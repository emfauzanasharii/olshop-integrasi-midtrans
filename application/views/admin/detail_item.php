<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Detail Item</h2>
     <div class="clearfix"></div>
   </div>

   <div class="x_content">
      <div class="row">
         <div class="col-md-5 col-sm-6">
            <img src="<?= base_url('assets/upload/'.$gambar); ?>" style="width:100%">
            <div class="row">
               <?php foreach ($img->result() as $key): ?>
                  <div class="col-md-4 product-image">
                     <img src="<?= base_url('assets/upload/'.$key->img); ?>">
                  </div>
               <?php endforeach; ?>
            </div>
         </div>
         <div class="col-md-6 col-sm-6">
            <table class="table table-striped">
               <tr>
                  <td width="100px;">
                     <span style="float:left">Nama Item</span>
                     <span style="float:right">:</span>
                  </td>
                  <td><span style="float:left"><?= $nama_item; ?></span></td>
               </tr>
               <tr>
                  <td width="100px;">
                     <span style="float:left">Harga Item</span>
                     <span style="float:right">:</span>
                  </td>
                  <td><span style="float:left"><?= 'Rp. '.number_format($harga, 0, ',','.'); ?></span></td>
               </tr>
               <tr>
                  <td width="100px;">
                     <span style="float:left">Stok Item</span>
                     <span style="float:right">:</span>
                  </td>
                  <td>
                     <span style="float:left">
                        <?php
                        if ($stok >= 10) {
                           echo '<label class="label-success" style="color:white; padding:3px 10px;">'.$stok.'</label>';
                        } elseif ($stok < 10 && $stok > 0) {
                              echo '<label class="label-warning" style="color:white; padding:3px 10px;">'.$stok.'</label>';
                        } else {
                           echo '<label class="label-danger" style="color:white; padding:3px 10px;">Habis</label>';
                        }
                        ?>
                     </span>
                  </td>
               </tr>
               <tr>
                  <td width="100px;">
                     <span style="float:left">Berat</span>
                     <span style="float:right">:</span>
                  </td>
                  <td><span style="float:left"><?= $berat; ?> gr</span></td>
               </tr>
               <tr>
                  <td width="100px;">
                     <span style="float:left">Status</span>
                     <span style="float:right">:</span>
                  </td>
                  <td>
                     <span style="float:left">
                        <?php if($status == 1) { echo 'Aktif'; } else { echo 'Tidak Aktif'; } ?>
                     </span>
                  </td>
               </tr>
               <tr>
                  <td width="100px;">
                     <span style="float:left">Deskripsi</span>
                     <span style="float:right">:</span>
                  </td>
                  <td><span style="float:left"><?= nl2br($deskripsi); ?></span></td>
               </tr>
               <tr>
                  <td width="100px;">
                     <span style="float:left">Kategori</span>
                     <span style="float:right">:</span>
                  </td>
                  <?php
                  $value = '';
                  foreach ($kategori->result() as $k) {
                     $value .= ', '.$k->kategori;
                  }
                  ?>
                  <td><span style="float:left"><?= trim($value, ', '); ?></span></td>
               </tr>
            </table>
            <div class="clearfix"></div>
            <div>
               <a href="<?= base_url('item/update_item/'.$id_item); ?>" class="btn btn-warning">Edit</a>
               <a href="#" class="btn btn-default" onclick="window.history.go(-1)">Kembali</a>
            </div>
         </div>
      </div>
   </div>
</div>
