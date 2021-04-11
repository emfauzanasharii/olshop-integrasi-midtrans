<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <!-- Meta, title, CSS, favicons, etc. -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>Dashboard</title>

      <!-- Bootstrap -->
      <link href="<?= base_url('admin_assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
      <!-- Font Awesome -->
      <link href="<?= base_url('admin_assets/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
      <!-- Data Tables -->
      <link href="<?= base_url('admin_assets/css/dataTables.bootstrap.min.css'); ?>" rel="stylesheet">
      <link href="<?= base_url('admin_assets/css/responsive.bootstrap.min.css'); ?>" rel="stylesheet">
      <!-- Custom Theme Style -->
      <link href="<?= base_url('admin_assets/css/custom.min.css'); ?>" rel="stylesheet">
      <style media="screen">
      .product-image{
         height:120px;
         width:120px;
         border: 1px solid #c1c1c1;
         padding: 5px;
         display: flex;
         align-items: center;
         margin-top: 10px;
         margin-right: 5px;
      }
      .product-image img{
         width: 100%;
         height: auto;
      }
      .card {
         margin:5px 4px 10px 0px;
         background-color: #fff;
         transition: box-shadow .25s;
         border: 1px solid #d9d9d9;
      }

      .card .card-image {
        display: flex;
        align-items: center;
        width: 185px;
        height: 200px;
      }

      .card .card-image img{
        width: 100%;
        height: auto;
      }

      .card .card-content .card-title {
        display: block;
        line-height: 32px;
        margin-bottom: 8px;
      }

      .card .card-content .card-title i {
        line-height: 32px;
      }

      .card .card-action {
        position: relative;
        background-color: inherit;
        border-top: 1px solid rgba(160, 160, 160, 0.2);
        padding: 10px 5px;
      }

      .card-image {
         height : 180px;
         text-align: center;
      }
      .card-action .btn-flat {
         width:100%;
         margin-bottom: 5px;
         text-align: left;
      }
      @media screen and (max-width: 400px){
         .card .card-image {
           display: flex;
           align-items: center;
           width: 100%;
           height: 280px;
         }
      }
      </style>
   </head>

   <body class="nav-md">
      <div class="container body">
         <div class="main_container">
            <?= $nav; ?>

            <!-- page content -->
            <div class="right_col" role="main">
               <?= $content; ?>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
               
               <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
         </div>
      </div>

      <!-- jQuery -->
      <script src="<?= base_url('admin_assets/js/jquery.min.js'); ?>"></script>
      <!-- Bootstrap -->
      <script src="<?= base_url('admin_assets/js/bootstrap.min.js'); ?>"></script>
      <!-- Data Tables -->
      <script src="<?= base_url('admin_assets/js/jquery.dataTables.min.js'); ?>"></script>
      <script src="<?= base_url('admin_assets/js/dataTables.bootstrap.min.js'); ?>"></script>
      <script src="<?= base_url('admin_assets/js/dataTables.responsive.min.js'); ?>"></script>
      <!-- Custom Theme Scripts -->
      <script src="<?= base_url('admin_assets/js/custom.min.js'); ?>"></script>
      <script type="text/javascript">
         function addlist(obj, out) {
            var grup = obj.form[obj.name];
            var len = grup.length;
            var list = new Array();

            if (len > 1) {
               for (var i = 0; i < len; i++) {
                  if (grup[i].checked) {
                     list[list.length] = grup[i].value;
                  }
               }
            } else {
               if (grup.checked) {
                  list[list.length] = grup.value;
               }
            }

            document.getElementById(out).value = list.join(', ');

            return;
         }
         $('.alert-message').alert().delay(3000).slideUp('slow');
      </script>
      <?php if($this->uri->segment(1) != 'administrator' && $this->uri->segment(1) != 'setting') { ?>
         <script type="text/javascript">
         $(document).ready(function(){
            <?php
               switch ($this->uri->segment(1)) {
                  case 'item':
                     $file = 'item';
                     break;
                  case 'tag':
                     $file = 'tag';
                     break;
                  case 'user':
                     $file = 'user';
                     break;
                  case 'transaksi':
                     $file = 'transaksi';
                     break;
               }
            ?>

            $('#datatable').DataTable({
               "processing": true, //Feature control the processing indicator.
               "serverSide": true, //Feature control DataTables' server-side processing mode.
               "order": [], //Initial no order.

               // Load data for the table's content from an Ajax source
               "ajax": {
                  "url": "<?=base_url($file.'/ajax_list')?>",
                  "type": "POST"
               },

              //Set column definition initialisation properties.
              "columnDefs": [
              {
                  "targets": [ 0 ], //first column / numbering column
                  "orderable": false, //set not orderable
              },
              ],

          });
         });
         </script>
      <?php } ?>
   </body>
</html>
