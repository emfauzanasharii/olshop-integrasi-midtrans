<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="x_panel">
   <div class="x_title">
      <h2>Managemen Item</h2>
      <div style="float:right">
         <a href="<?= base_url('item/add_item'); ?>" class="btn btn-primary">Tambah Item</a>
      </div>
     <div class="clearfix"></div>
   </div>

   <div class="x_content">
      <div class="row">
         <div class="col-md-12">
            <table class="table table-striped table-bordered dt-responsive nowrap" id="datatable">
               <thead>
                  <tr>
                     <th width="5%">#</th>
                     <th width="45%">Nama Item</th>
                     <th>Harga</th>
                     <th>Status</th>
                     <th>Stok</th>
                     <th width="12%">Opsi</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
