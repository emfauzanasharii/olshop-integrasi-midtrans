<h4><i class="fa fa-exchange"></i> Detail Transaksi</h4>
<hr />
<br />
<?php
$data = $get->row();
?>
<div class="row">
   <div class="col m2 s4">
      <b>Id Pesanan</b>
   </div>
   <div class="co m6 s6">
      <b>: <?= $data->id_order; ?></b>
   </div>
</div>
<div class="row">
   <div class="col m2 s4">
      <b>Tujuan</b>
   </div>
   <div class="co m6 s6">
      <b>: <?= $data->tujuan; ?>, <?= $data->kota; ?></b>
   </div>
</div>
<div class="row">
   <div class="col m2 s4">
      <b>Kurir / Layanan</b>
   </div>
   <div class="co m6 s6">
      <b>: <?= $data->kurir; ?> / <?= $data->service; ?></b>
   </div>
</div>
<div class="row">
   <div class="col m2 s4">
      <b>Bukti Pengiriman</b>
   </div>
   <div class="co m6 s6">
      <b>: <?= '<a style="color:#2196f3" href="'.base_url().'assets/bukti/'.$data->pengiriman.'" target="_blank">'.$data->pengiriman.'</a>'; ?></b>
   </div>
</div>
<div class="row">
   <div class="col m2 s4">
      <b>Status</b>
   </div>
   <div class="co m6 s6">
      <b>: <?= ucfirst($data->status_proses); ?></b>
   </div>
</div>
<div class="row">
   <table class="bordered responsive-table col m8 s12 offset-m1">
      <thead>
         <tr>
            <th width="5%" class="center">#</th>
            <th width="20%" class="center">Nama Item</th>
            <th width="15%" class="center">Jumlah Pesan</th>
            <th width="15%" class="center">Biaya</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $i = 1;
         $total_biaya = 0;
         foreach ($get->result() as $key) :
            $total_biaya += $key->biaya;
         ?>

            <tr>
               <td class="center"><?= $i++; ?></td>
               <td class="center"><?= $key->nama_item; ?></td>
               <td class="center"><?= $key->qty; ?></td>
               <td style="text-align:right">Rp. <?= number_format($key->biaya, 0, ',', '.'); ?>,-</td>
            </tr>

         <?php endforeach; ?>
         <tr>
            <td colspan="3" class="center">Ongkos Kirim</td>
            <td style="text-align:right">Rp. <?php echo number_format($data->total - $total_biaya,0,',','.'); ?>,-</td>
         </tr>
         <tr>
            <td colspan="3" class="center">Total Biaya</td>
            <td style="text-align:right">Rp. <?php echo number_format($data->total,0,',','.'); ?>,-</td>
         </tr>
      </tbody>
   </table>
</div>
<br />
<div class="right">
   <button type="button" class="btn red" onclick="window.history.go(-1)">Kembali</button>
</div>
<br/>
