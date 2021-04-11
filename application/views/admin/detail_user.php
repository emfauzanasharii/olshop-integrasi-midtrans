<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Detail User</h2>
     <div class="clearfix"></div>
   </div>
   <?php
   $user = $data->row();
   ?>
   <div class="x_content">
      <div class="row">
         <div class="col-md-8 col-sm-12">
            <table class="table table-striped">
               <tr>
                  <td width="150px;">Nama Lengkap</td>
                  <td>: <?= $user->fullname; ?></td>
               </tr>
               <tr>
                  <td width="150px;">Username</td>
                  <td>: <?= $user->username; ?></td>
               </tr>
               <tr>
                  <td width="150px;">Alamat</td>
                  <td>: <?= $user->alamat; ?></td>
               </tr>
               <tr>
                  <td width="150px;">Jenis Kelamin</td>
                  <td>: <?php if($user->jk == 'L') {echo "Laki - laki"; } else { echo "Perempuan"; }?></td>
               </tr>
               <tr>
                  <td width="150px;">E-mail</td>
                  <td>: <?= $user->email; ?></td>
               </tr>
               <tr>
                  <td width="150px;">Telp</td>
                  <td>: <?= $user->telp; ?></td>
               </tr>
               <tr>
                  <td width="150px;">Status</td>
                  <td>: <?php if($user->status == 1) {echo "Active"; } else { echo "Non Active"; }?></td>
               </tr>
            </table>
            <a href="#" class="btn btn-default" onclick="window.history.go(-1)">Kembali</a>
         </div>
      </div>
   </div>
</div>
