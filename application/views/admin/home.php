<div class="">
   <div class="row top_tiles">
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
         <div class="tile-stats">
            <div class="icon"><i class="fa fa-users"></i></div>
            <div class="count"><?=$user;?></div>
            <h3>Jumlah User</h3>
         </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
         <div class="tile-stats">
            <div class="icon"><i class="fa fa-cubes"></i></div>
            <div class="count"><?=$item;?></div>
            <h3>Jumlah Item</h3>
         </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
         <div class="tile-stats">
            <div class="icon"><i class="fa fa-tags"></i></div>
            <div class="count"><?=$tag;?></div>
            <h3>Jumlah Kategori</h3>
         </div>
      </div>
      <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
         <div class="tile-stats">
            <div class="icon"><i class="fa fa-exchange"></i></div>
            <div class="count"><?=$trans;?></div>
            <h3>Transaksi Berhasil</h3>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-12">
         <div class="x_panel">
            <h3>Transaksi Terakhir</h3>
            <hr />
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <th>#</th>
                     <th>Id Order</th>
                     <th>Nama Pemesan</th>
                     <th>Kota Tujuan</th>
                     <th>Tanggal Pesan</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  $i = 1;
                  foreach($last->result() as $key) :
                  ?>
                     <tr>
                        <td><?=$i++;?></td>
                        <td><?=$key->id_order;?></td>
                        <td><?=$key->nama_pemesan;?></td>
                        <td><?=$key->kota;?></td>
                        <td><?=date('d M Y', strtotime($key->tgl_pesan));?></td>
                     </tr>
                  <?php endforeach; ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
