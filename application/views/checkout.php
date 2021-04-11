<div class="row">
   <div class="col m10 s12 offset-m1">
      <h4 style="color:#939393"><i class="fa fa-shopping-bag"></i> Checkout</h4>
      <hr />
      <br />
      <?= validation_errors('<p style="color:red">', '</p>'); ?>
      <form action="<?=site_url()?>/snap/finish" method="post">
         <div class="col m10 s12">  

            <div class="row">
               <div class="col m8 s12">
                  <label>Provinsi</label>
                  <select class="browser-default" name="prov" id="prov">
                     <option value="" disabled selected>-- Pilih Provinsi --</option>
                     <?php $this->load->view('prov'); ?>
                  </select>
               </div>
            </div>

            <div class="row">
               <div class="col m8 s12">
                  <label>Pilih Kota / Kabupaten</label>
                  <select name="kota" class="browser-default" id="kota">
                     <option value="" disabled selected>-- Kota / Kabupaten --</option>
                  </select>
               </div>
            </div>

            <div class="row">
               <div class="input-field col m8 s12">
                  <input type="text" id="alamat" class="validate" name="alamat" value="">
                  <label for="alamat">Alamat</label>
               </div>
               <div class="input-field col m4 s12">
                  <input type="number" id="kd_pos" class="validate" name="kd_pos" value="">
                  <label for="kd_pos">Kode Pos</label>
               </div>
            </div>

            <div class="row">
               <div class="col m8 s12">
                  <label>Pilih Kurir</label>
                  <select class="browser-default" name="kurir" id="kurir">
                     <option value="pos">POS</option>
                     <option value="jne">JNE</option>
                  </select>
               </div>
            </div>

            <div class="row">
               <div class="col m8 s12">
                  <label>Pilih Layanan</label>
                  <select class="browser-default" name="layanan" id="layanan">
                     <option value="" disabled selected>Pilih Layanan</option>
                  </select>
               </div>
               <div class="col m4 s12">
                  <label>Ongkos Kirim</label>
                  <input type="text" name="ongkir" value="0" id="ongkir" class="uang" readonly>
               </div>
            </div>

            <div class="row">
               <div class="input-field col m4 s12 offset-m8">
                  <input type="text" name="total" value="<?= $this->cart->total(); ?>" id="total" class="uang" readonly>
                  <label>Total Biaya</label>
               </div>
            </div>

            <br />

            <div class="row right">
               <button type="button" onclick="window.history.go(-1)" class="btn red waves-effect waves-light">Kembali</button>
               <button id="pay-button" class="btn blue waves-effect waves-light">Bayar <i class="fa fa-paper-plane"></i></button>
            </div>

         </div>
      </form>
   </div>
</div>

 <script type="text/javascript">
      
    $('#pay-button').click(function (event) {
      event.preventDefault();
      $(this).attr("disabled", "disabled");

      
    var total=parseInt($("#total").val().replace('.',''));
    var ongkir=$('#ongkir').val();
    var prov=$("#prov").val();
    var kab=$("#kota").val();
    var alamat=$("#alamat").val();
    var pos=$("#kd_pos").val();
    var kurir=$("#kurir").val();
    var layanan=$("#layanan").val();
    // console.log(total);

   // console.log(kab);
   // console.log(prov);
   // console.log(alamat);
   // console.log(pos);
    $.ajax({
      type:'POST',
      url: '<?=base_url()?>/snap/token',
      data:{total:total,
            ongkir:ongkir,
            prov:prov,kab:kab,
            alamat:alamat,pos:pos,
            kurir:kurir,layanan:layanan
            },
      cache: false,

      success: function(data) {
        //location = data;

        console.log('token = '+data);
        
        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');

        function changeResult(type,data){
          $("#result-type").val(type);
          $("#result-data").val(JSON.stringify(data));
          //resultType.innerHTML = type;
          //resultData.innerHTML = JSON.stringify(data);
        }

        snap.pay(data, {
          
          onSuccess: function(result){
            changeResult('success', result);
            console.log(result.status_message);
            console.log(result);
            $("#payment-form").submit();
          },
          onPending: function(result){
            changeResult('pending', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          },
          onError: function(result){
            changeResult('error', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          }
        });
      }
    });
  });

  </script>
