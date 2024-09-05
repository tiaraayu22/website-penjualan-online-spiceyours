<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style type="text/css">
    .MasterContainer {
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }
    .title {
      margin-bottom: 22px;
    }

    #result {
        left: 2.3%;
        width: 95%;
        position: absolute;
        z-index: 1000;
    }
  </style>
<script>
    var subtotal = <?=$subtotal?>;

        function formatRupiah(subtotal) {
              subtotal = parseFloat(subtotal);
              let rupiah = subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,').replace('.', ',');
              return  rupiah;
          }

        function showAlert(element) {
          const harga = element.getAttribute('data-harga');
          if (harga<subtotal) {
              $('#ongkir').html("Rp "+  formatRupiah(harga));
              var grandtot = subtotal+parseInt(harga);
              $('#grand-total').html("Rp " + formatRupiah(grandtot) );
              document.getElementById("tombol-simpan").disabled = false;
          } else {
              $('#ongkir').html("Rp "+  formatRupiah(harga));
              var grandtot = subtotal+parseInt(harga);
              $('#grand-total').html("Rp " + formatRupiah(grandtot) );
              document.getElementById("tombol-simpan").disabled = true;
              alert("Ongkos Kirim Lebih mahal dari total pembelian");
          }
        }
</script>
<div class="hero-wrap hero-bread" style="background-image: url('<?php echo get_theme_uri('images/kucing5.jpg'); ?>');">
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><?php echo anchor(base_url(), 'Home'); ?></span> <span>Checkout</span></p>
          <h1 class="mb-0 bread">Checkout</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section">
    <div class="container">
    <form action="<?php echo site_url('shop/checkout/order'); ?>" method="POST">

      <div class="row justify-content-center">
        <div class="col-xl-7 ftco-animate">
                <h3 class="mb-4 billing-heading">Alamat Pengiriman</h3>

                <div class="form-group">
                    <label for="name" class="form-control-label">Pengiriman untuk (nama):</label>
                    <input type="text" name="name" value="<?php echo $customer->name; ?>" class="form-control" id="name" required>
                </div>

                <div class="form-group">
                    <label for="hp" class="form-control-label">No. HP:</label>
                    <input type="text" name="phone_number" value="<?php echo $customer->phone_number; ?>" class="form-control" id="hp" required>
                </div>

                <div class="form-group">
                    <label for="address" class="form-control-label">Alamat:</label>
                    <textarea name="address" class="form-control" id="address" required><?php echo $customer->address; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="address" class="form-control-label">Kota / Kabupaten:</label>
                    <div class="MasterContainer">
                        </div>
                          <div class="form-group">
                            <input type="text" id="search" onkeyup="changeInput(this.value)" class="form-control form-control-lg" placeholder="Masukan 3 atau lebih huruf" value="<?=$alamatnya->alamatnya?>">
                            <div>
                              <div id="result" class="list-group"></div>
                            </div>
                          </div>

                </div>


                <div class="form-group">
                    <label for="note" class="form-control-label">Catatan:</label>
                    <textarea name="note" class="form-control" id="note"></textarea>
                </div>

        </div>
        <div class="col-xl-5">
            <div class="row mt-5 pt-3">

                <div class="col-md-12 d-flex mb-5">
                  <div class="cart-detail cart-total p-3 p-md-4">
                    <h3 class="billing-heading mb-4">Pengiriman</h3>
                    <hr>
                    <div class="form-group">
                      <div class="col-md-12" id="kurirnya">
                        <?php
                          $first = true;
                          foreach ($kurir as $value) { 
                          ?>
                          <div class="radio">
                             <label><input type="radio" name="payment" class="mr-2" value="<?=$value->service?>" data-harga="<?=$value->cost['0']->value?>" onclick="showAlert(this)" <?php if ($first) { echo 'checked'; $first = false; } ?> > <?=$value->service?>-<?=$value->description?> ( <?=$value->cost['0']->etd?> Hari)<br>Rp <?=format_rupiah($value->cost['0']->value)?></label>
                          </div>  
                        <?php }
                        ?>
                      </div>
                      </div>
                  </div>
                </div>

                <div class="col-md-12 d-flex mb-5">
                    <div class="cart-detail cart-total p-3 p-md-4">
                        <h3 class="billing-heading mb-4">Rincian Belanja</h3>
                        <p class="d-flex">
                                  <span>Subtotal</span>
                                  <span>Rp <?php echo format_rupiah($subtotal); ?></span>
                              </p>
                              <p class="d-flex">
                                  <span>Ongkos kirim</span>
                                  <span id="ongkir"><?php echo $ongkir; ?></span>
                              </p>
                              <p class="d-flex">
                                  <span>Kupon</span>
                                  <span><?php echo $discount; ?></span>
                              </p>
                              <hr>
                              <p class="d-flex total-price">
                                  <span>Total</span>
                                  <span id="grand-total">Rp <?php echo format_rupiah($total); ?></span>
                              </p>
                              </div>
                </div>
                <div class="col-md-12">
                  <div class="cart-detail p-3 p-md-4">
                      <h3 class="billing-heading mb-4">Metode Pembayaran</h3>
                      <div class="form-group">
                          <div class="col-md-12">
                              <div class="radio">
                                 <label><input type="radio" name="payment" class="mr-2" value="1"> Transfer bank</label>
                              </div>
                          </div>
                      </div>    
                  </div>
                  <div class="form-group text-right" style="margin-top: 10px;">
                      <input type="submit" id="tombol-simpan" class="btn btn-info py-2 px-2" value="Buat Pesanan">
                  </div>
                </div>

                
            </div>
        </div> <!-- .col-md-8 -->
      </div>

    </form>
    </div>
  </section> <!-- .section -->


    <script type="text/javascript">

      function changeInput(val) {

        if (val.length>=3) {
          var apiUrl = "<?=base_url()?>index.php/auth/register/getCity?q="+val;
          $.ajax({
                url: apiUrl,
                type: 'GET',
                dataType: 'json',
                success: function(data) {

                  document.getElementById("result").innerHTML = "";
                  data['results'].forEach(function(item, index) {

                    document.getElementById("result").innerHTML += "<a class='list-group-item list-group-item-action' href='#' data-id='"+item.id+"' data-text='"+item.text+"' onclick='setSearch(this)'>" + item.text + "</a>";
                  });

                },
                error: function(xhr, status, error) {
                    $('#result').html('Error: ' + error);
                }
            });
        }

      }


      function setSearch(value) {
        let id = value.getAttribute("data-id");
        let text = value.getAttribute("data-text");
        var radionya = "";
        var harga = "0";
        document.getElementById("tombol-simpan").disabled = true;
        $('#ongkir').html("Mohon Pilih Jenis pengiriman ");          
        $('#grand-total').html("Rp " + formatRupiah(subtotal) );
        document.getElementById("kurirnya").innerHTML = "Loading ...";

        var apiUrl = "<?=base_url()?>index.php/shop/getCost?q="+id;
          $.ajax({
                url: apiUrl,
                type: 'GET',
                dataType: 'json',
                success: function(data) {

                  data.forEach(function(item, index) {
                    radionya += '<div class="radio">\
                             <label><input type="radio" name="payment" class="mr-2" value="'+item['service']+'" data-harga="'+item['cost']['0']['value']+'" onclick="showAlert(this)" > '+item['service']+'-'+item['description']+' ( '+item['cost']['0']['etd']+' Hari)<br>Rp '+item['cost']['0']['value']+'</label>\
                          </div>';
                  })
                  
                  document.getElementById("kurirnya").innerHTML = radionya;

                },
                error: function(xhr, status, error) {
                    $('#result').html('Error: ' + error);
                }
            });

              document.getElementById('search').value = text;
              document.getElementById("result").innerHTML = "";
      }
  </script>

