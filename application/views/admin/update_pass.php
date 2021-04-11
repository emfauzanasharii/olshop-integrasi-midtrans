<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Update Passwordl</h2>
      <div class="clearfix"></div>
      <?= validation_errors('<p style="color:red">','</p>'); ?>
   </div>

   <div class="x_content">
      <br />
      <div class="alert-warning" style="padding:10px">
         <h3>Peringatan !</h3>
         <p>Setelah password diperbarui, Anda diwajibkan login ulang</p>
      </div>
      <div class="clearfix"></div>
      <br />
      <form class="form-horizontal form-label-left" action="" method="post">
         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Password Baru
            </label>
            <div class="col-md-5 col-sm-6 col-xs-12">
               <input type="password" class="form-control col-md-7 col-xs-12" name="password1">
            </div>
         </div>

         <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12" >Password Lama
            </label>
            <div class="col-md-5 col-sm-6 col-xs-12">
               <input type="password" class="form-control col-md-7 col-xs-12" name="password2">
               <em class="help-text">* Masukkan Password anda untuk konfirmasi perubahan</em>
            </div>
         </div>

         <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-2">
               <button type="submit" name="submit" class="btn btn-primary" value="Submit">Simpan Perubahan</button>
               <button type="button" onclick="window.history.go(-1)" class="btn btn-danger">Kembali</button>
            </div>
         </div>
      </form>
   </div>
</div>
