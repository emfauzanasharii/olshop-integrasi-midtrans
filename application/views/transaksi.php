<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<h4><i class="fa fa-exchange"></i> Data Transaksi</h4>
<hr />
<br />
<div class="row">
   <table class="bordered responsive-table col m12 s12">
      <thead>
         <tr>
            <th width="5%" class="center">#</th>
            <th width="20%" class="center">Id Transaksi</th>
            <th width="15%" class="center">Tanggal Pesan</th>
            <th width="15%" class="center">Batas Bayar</th>
            <th width="15%" class="center">Total Biaya</th>
            <th width="10%" class="center">Status</th>
            <th width="15%" class="center">opsi</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $today = (abs(strtotime(date("Y-m-d"))));
         $i = 1;

         foreach ($get->result() as $key) :
         ?>

            <tr>
               <td class="center"><?= $i++; ?></td>
               <td class="center"><?= $key->id_order; ?></td>
               <td class="center"><?= date("d M Y", strtotime($key->tgl_pesan)); ?></td>
               <td class="center"><?= date("d M Y", strtotime($key->bts_bayar)); ?></td>
               <td style="text-align:right">Rp. <?= number_format($key->total, 0, ',', '.') ?>,-</td>
               <td class="center">
                  <?php
                  $batas = (abs(strtotime($key->bts_bayar)));

                  if ($today > $batas && $key->status_proses == 'belum') {
                     echo 'Kedaluarsa';
                  } else {
                     echo ucfirst($key->status_proses);
                  }
                  ?>
               </td>
               <td class="center">
                  <a href="<?=site_url('home/detail_transaksi/'.$key->id_order)?>" class="btn btn-floating green"><i class="fa fa-search-plus"></i></a>

                  <?php
                  if ($key->status_proses != 'proses' && $key->status_proses != 'selesai') {
                  ?>
                     <a href="<?=site_url('home/hapus_transaksi/'.$key->id_order);?>" class="btn btn-floating red" onclick="return confirm('Yakin ingin menghapus data ini ?')"><i class="fa fa-trash"></i></a>
                  <?php
                  }
                  if ($key->status_proses == 'proses') {
                  ?>
                     <a href="<?=site_url('home/transaksi_selesai/'.$key->id_order);?>" class="btn btn-floating blue"><i class="fa fa-check"></i></a>
                  <?php
                  }
                  ?>
               </td>
            </tr>

         <?php endforeach; ?>
      </tbody>
   </table>
</div>
<br />
<div class="right">
   <button type="button" class="btn red" onclick="window.history.go(-1)">Kembali</button>
</div>
<br/>
