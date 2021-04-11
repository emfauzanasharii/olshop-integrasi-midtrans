<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Edit Profil</h2>
      <div class="clearfix"></div>
      <?= validation_errors('<p style="color:red">','</p>'); ?>
   </div>

   <div class="x_content">
      <br />
      <form class="form-horizontal form-label-left" action="" method="post">
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Username
            </label>
            <div class="col-md-5 col-sm-6 col-xs-12">
               <input type="text" class="form-control" name="username" value="<?= $username; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Fullname
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               <input type="text" class="form-control" name="fullname" value="<?= $fullname; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Email
            </label>
            <div class="col-md-5 col-sm-6 col-xs-12">
               <input type="email" class="form-control col-md-7 col-xs-12" name="email" value="<?= $email; ?>">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Password
            </label>
            <div class="col-md-5 col-sm-6 col-xs-12">
               <input type="password" class="form-control col-md-7 col-xs-12" name="password">
               <em class="help-text">* Masukkan Password anda untuk konfirmasi perubahan</em>
            </div>
         </div>

         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
               <button type="submit" name="submit" class="btn btn-primary" value="Submit">Simpan Perubahan</button>
               <button type="button" class="btn btn-danger" onclick="window.history.go(-1)">Kembali</button>
            </div>
         </div>
      </form>
   </div>
</div>
