<?php


$prof = $profil->row();

?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1" style="color: black">

      <title>QHome Mart</title>
      <!-- Materialize Css -->
      <link rel="stylesheet" href="<?= base_url('assets/css/materialize.min.css'); ?>">
      <!-- Font-Awesome -->
      <link rel="stylesheet" href="<?= base_url('admin_assets/font-awesome/css/font-awesome.min.css'); ?>">
      <!-- customCss -->
      <link rel="stylesheet" href="<?= base_url('assets/css/custom.css'); ?>">
       <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="SB-Mid-client-E851H5heVm6m8Kd0"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

   </head>
   <body>
      <header>
         <nav class="red darken-2">
            <div class="nav-wrapper">
               <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
               <a href="<?=base_url('home');?>" class="brand-logo"><i class="fa fa-shopping-cart"></i>QHome Mart</a>
               <div style="width:30%;" class="left hide-on-med-and-down">
                  <form action="<?= base_url('home/search'); ?>" method="post" class="input-group">
                     <input type="search" class="top" name="search" placeholder="Search">
                  </form>
               </div>
               <ul id="nav-mobile" class="right hide-on-med-and-down" style="max-width:45%">
                  <li><a href="#" class="dropdown-button" data-activates="kat1"><i class="fa fa-tags"></i> Kategori<i class="fa fa-caret-down right"></i></a></li>

                  <ul class="dropdown-content" id="kat1">
                     <?php foreach ($kategori->result() as $kat): ?>
                        <li>
                           <a href="<?=base_url('home/kategori/'.$kat->url);?>"> <?=$kat->kategori;?></a>
                        </li>
                     <?php endforeach; ?>
                  </ul>
                 
                  <li>
                     <a href="<?= base_url('cart'); ?>">
                        <i class="fa fa-shopping-cart"></i>
                        <?php
                        if ($this->cart->total() > 0) {
                           echo 'Rp. '.number_format($this->cart->total(), 0, ',', '.');
                        } else {
                           echo 'cart';
                        }
                        ?>
                     </a>
                  </li>
               </ul>
            </div>
            <!-- Side Nav -->
            <ul id="slide-out" class="side-nav collapsible" data-collapsible="accordion">
               <li>
                  <form action="<?= base_url('home/search'); ?>" method="post" class="input-group">
                     <input type="search" name="search" placeholder="Search">
                  </form>
               </li>
               <li><a href="<?= base_url(); ?>"><i class="fa fa-home"></i> Home</a></li>
               <li>
                 <a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-tag" style="font-size:16px;margin-left:-5px"></i> Kategori<i class="fa fa-caret-down right"></i></a>
                  <ul class="collapsible-body" style="padding:0px; padding-left:10px;">
                      <?php foreach ($kategori->result() as $kat): ?>
                        <li>
                            <a href="<?=base_url('home/kategori/'.$kat->url);?>"> <?=$kat->kategori;?></a>
                        </li>
                      <?php endforeach; ?>
                  </ul>
                </li>
               <li><a href="<?= base_url('cart'); ?>"><i class="fa fa-shopping-cart"></i> Cart 
                  <div align="right">
                  <?php
                        if ($this->cart->total() > 0) {
                           echo 'Rp. '.number_format($this->cart->total(), 0, ',', '.');
                        } else {
                           echo 'cart';
                        }
                        ?>
                        </div>
               </a></li>
            </ul>
         </nav>
      </header>

      <main>

         <div class="cont">
            <!-- start item -->
            <div class="item">

               <?= $content; ?>
            <!-- end item -->
            </div>

           
         </div>
          <footer class="page-footer orange darken-3">
               <div class="footer-copyright">
                  <div class="container">
                     Copyright © <?= date('Y')?>. All Rights Reserved.
                  </div>
               </div>
            </footer>
      </main>

      <a href="" class="btn-floating btn-large waves-effect waves-light red back-top"><i class="fa fa-angle-double-up"></i></a>

      <!-- Jquery -->
      <script type="text/javascript" src="<?= base_url('admin_assets/js/jquery.min.js'); ?>"></script>
      <!-- materialize -->
      <script type="text/javascript" src="<?= base_url('assets/js/materialize.min.js'); ?>"></script>
      <script type="text/javascript" src="<?= base_url('assets/js/custom.js'); ?>"></script>
      <script type="text/javascript" src="<?= base_url('assets/js/jquery.mask.min.js'); ?>"></script>
      <!-- custom -->
      <?php if(strtolower($this->uri->segment(1)) == 'checkout') { ?>

         <script type="text/javascript">

            $(document).ready(function() {
               function convertToRupiah(angka)
               {

                  var rupiah = '';
                  var angkarev = angka.toString().split('').reverse().join('');

                  for(var i = 0; i < angkarev.length; i++)
                    if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';

                  return rupiah.split('',rupiah.length-1).reverse().join('');

               }

               $('#prov').change(function() {
                  var prov = $('#prov').val();

                  $.ajax({
                     url: "<?=base_url();?>checkout/city",
                     method: "POST",
                     data: { prov : prov },
                     success: function(obj) {
                        $('#kota').html(obj);
                     }
                  });
               });

               $('#kota').change(function() {
                  var dest = $('#kota').val();
                  var kurir = $('#kurir').val()

                  $.ajax({
                     url: "<?=base_url();?>checkout/getcost",
                     method: "POST",
                     data: { dest : dest, kurir : kurir },
                     success: function(obj) {
                        $('#layanan').html(obj);
                     }
                  });
               });

               $('#kurir').change(function() {
                  var dest = $('#kota').val();
                  var kurir = $('#kurir').val()

                  $.ajax({
                     url: "<?=base_url();?>checkout/getcost",
                     method: "POST",
                     data: { dest : dest, kurir : kurir },
                     success: function(obj) {
                        $('#layanan').html(obj);
                     }
                  });
               });

               $('#layanan').change(function() {
                  var layanan = $('#layanan').val();

                  $.ajax({
                     url: "<?=base_url();?>checkout/cost",
                     method: "POST",
                     data: { layanan : layanan },
                     success: function(obj) {
                        var hasil = obj.split(",");

                        $('#ongkir').val(convertToRupiah(hasil[0]));
                        $('#total').val(convertToRupiah(hasil[1]));
                     }
                  });
               });
            });
         </script>

      <?php } ?>

      <script type="text/javascript">
         $(".button-collapse").sideNav();
         $(".modal").modal();
         $('.carousel').carousel();

         $(document).ready(function() {
            $(".uang").mask("00,000.000.000", {reverse:true});

            $(window).scroll(function(){
               if ($(this).scrollTop() > 100) {
                  $('.back-top').fadeIn();
              	} else {
                  $('.back-top').fadeOut();
               }
            });
            $('.back-top').click(function(){
               $("html, body").animate({ scrollTop: 0 }, 600);
            	return false;
            });
         });
         $('.alert-message').alert().delay(3000).slideUp('slow');
      </script>
   </body>
</html>