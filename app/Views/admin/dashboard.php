<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Admin Paneli</title>
<style>
:root { 
    --bg: #0d0d0d;          /* Genel arka plan */
    --card: #1a1a1a;        /* Kart / tablo arka planı */
    --primary: #00acc1;     /* Ana renk (buton, başlık) */
    --text: #f0f0f0;        /* Açık gri yazı */
    --hover: #222222;       /* Satır hover rengi */
    --border: #2c2c2c;      /* Kenarlık */
    --danger: #d32f2f;      /* Tehlike / sil butonları */
    --danger-hover: #b71c1c; /* Danger hover */
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #181818 !important; 
    color: var(--text);
    padding: 40px;
}

h1, h2 {
    color: #00acc1 !important;  /* Başlıklar kesin mavi olacak */
    margin-bottom: 20px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 5px;
}


table {
    width: 100%;
    border-collapse: collapse;
    background-color: var(--card);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.8);
    color: var(--text);
}

th, td {
    padding: 16px;
    text-align: left;
    border-bottom: 1px solid var(--border);
    color: var(--text) !important;
}

th {
    background-color: #222222;
    color: var(--primary);
    font-weight: 600;
    letter-spacing: 0.5px;
}

tr:hover {
    background-color: var(--hover);
    cursor: default;
}

a, button.btn {
    display: inline-block;
    background-color: var(--primary);
    color: #fff;
    padding: 10px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
}


a.btn:hover, button.btn:hover {
    background-color: #4caf50;  
    color: #fff;                
}

.action {
    display: flex;
    gap: 10px;
    align-items: center;
}

button.danger {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    background-color: var(--danger);
    color: #fff;
    transition: 0.3s;
}

button.danger:hover {
    background-color: var(--danger-hover);
}

.note {
    margin: 10px 0 20px;
    color: #aaa;
    font-size: 14px;
}

/* Responsive (isteğe bağlı) */
@media screen and (max-width: 768px) {
    body {
        padding: 20px;
    }

    table th, table td {
        padding: 12px;
    }

    a, button.btn {
        padding: 8px 14px;
        font-size: 14px;
    }
}
/* DataTables Dark Tema */
.dataTables_wrapper {
  color: #f0f0f0;
}

.dataTables_wrapper .dataTables_filter input,
.dataTables_wrapper .dataTables_length select {
  background-color: #0d0d0d;   /* Siyah arka plan */
  color: #00acc1;              /* Mavi yazı */
  border: 1px solid #2c2c2c;
  border-radius: 6px;
  padding: 6px 10px;
}

.dataTables_wrapper .dataTables_filter label,
.dataTables_wrapper .dataTables_length label {
  color: #00acc1;  /* Label mavi */
}

/* Pagination butonları */
.dataTables_wrapper .dataTables_paginate .paginate_button {
  background-color: #1a1a1a;
  color: #00acc1 !important;
  border: 1px solid #2c2c2c;
  border-radius: 6px;
  margin: 2px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background-color: #00acc1 !important;
  color: #fff !important;
  border: 1px solid #00acc1;
}

/* Aktif sayfa */
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background-color: #00acc1 !important;
  color: #fff !important;
  border: 1px solid #00acc1;
}

/* Info yazısı (Alt kısım) */
.dataTables_wrapper .dataTables_info {
  color: #aaa;
}


</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
  toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": false,
  "progressBar": true,
  "positionClass": "toast-top-right",
  "preventDuplicates": true,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}

const toastSuccess = (title = "", text = "") => {
  toastr["success"](text, title);
}

const toastError = (title = "", text = "") => {
  toastr["error"](text, title);
}

const toastInfo = (title = "", text = "") => {
  toastr["info"](text, title);
}

const toastWarning = (title = "", text = "") => {
  toastr["warning"](text, title);
}

//bunları daha sonrasında global bi index yapıp (view için), hepsini standart tanımlatıcam sana. ama bu tür js fonksiyonlarını vs. (Heryerde kullanabileceğin tarzda olanları) custom.js gib ibişey oluşturup oraya at, daha sonra çağır custom.js'i
</script>
</head>
<body>
<h1>Admin Paneli</h1>

<h2>Ürünler</h2>

<p><button id="addProduct" class="btn">➕ Yeni Ürün Ekle</button></p>
<!-- href="/php/php_calısmaları/eticaret-main/public/admin/addProduct" -->

<!-- ben bunu böyle yapıyorum, sen daha düzenli olsun diye ister sayfanın sonuna koy, ister modal için ayrı bir dosya oluşturup, buraya require ile çağır, sana kalmış düzen konusu-->
 <form id="addProductForm" enctype="multipart/form-data">
  <div class="modal fade" id="addProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Yeni Ürün Ekleme</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"> 
        
            <div class="form-group">
              <label>Ürün Adı:</label>
              <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
              <label>Fiyat:</label>
              <input type="text" name="price" class="form-control" required>
            </div>

            <div class="form-group">
              <label>Açıklama:</label>
              <textarea class="form-control" name="description"></textarea>
            </div>

            <div class="form-group">
              <label>Stok:</label>
              <input type="number" class="form-control" name="stock">
            </div>

            <div class="form-group">
              <label>Resim:</label>
              <input type="file" name="img" class="form-control" accept="image/*">
            </div>

      
        </div>
        <div class="modal-footer"> 
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sie</button>
          <button type="submit" class="btn btn-primary">Ekle agacım</button>
        </div>
      </div>
    </div>
  </div>
</form>


<!-- TEK MODAL İLE ÇÖZÜMMM -->

<table id="productsTable">
  <thead>
    <tr>
      <th>ID</th><th>Ad</th><th>Fiyat</th><th>Açıklama</th><th>Stok</th><th>İşlem</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!empty($products)): foreach($products as $product): ?>
      <tr id="product-<?= (int)$product['id'] ?>">
        <td><?= (int)$product['id'] ?></td>
        <td><?= htmlspecialchars($product['name']) ?></td>
        <td><?= htmlspecialchars($product['price']) ?> ₺</td>
        <td><?= htmlspecialchars($product['description']) ?></td>
        <td><?= htmlspecialchars($product['stock']) ?></td>
        <td class="action">
          <button class="danger" onclick="deleteProduct(<?= (int)$product['id'] ?>)">Sil</button>
          <button class="btn editProduct" 
                  data-id="<?= $product['id'] ?>"
                  data-name="<?= htmlspecialchars($product['name']) ?>"
                  data-price="<?= htmlspecialchars($product['price']) ?>"
                  data-description="<?= htmlspecialchars($product['description']) ?>"
                  data-stock="<?= htmlspecialchars($product['stock']) ?>"
                  data-img="<?= htmlspecialchars($product['img']) ?>">
              Düzenle
          </button>
        </td>
      </tr>
    <?php endforeach; else: ?>
      <tr><td colspan="6">Hiç ürün yok.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<!-- Modal kısmı -->

<div class="modal fade" id="editProductModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editProductForm" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Ürün Düzenle</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id">

          <div class="form-group">
            <label>Ürün Adı:</label>
            <input type="text" name="name" id="edit-name" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Fiyat:</label>
            <input type="text" name="price" id="edit-price" class="form-control" required>
          </div>

          <div class="form-group">
            <label>Açıklama</label>
            <textarea name="description" id="edit-description" class="form-control"></textarea>
          </div>

          <div class="form-group">
            <label>Stok:</label>
            <input type="number" name="stock" id="edit-stock" class="form-control">
          </div>

          <div class="form-group">
            <label>Mevcut Resim:</label>
            <img id="edit-img" src="" alt="Ürün Resmi" style="max-width:100px;">
          </div>

          <div class="form-group">
              <label>Yeni Resim Yükle:</label>
              <input type="file" name="img" id="edit-new-img" class="form-control">
          </div>
        </div> 

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
          <button type="submit" class="btn btn-primary">Güncelle</button>

        </div>
      </form> 
    </div>
  </div>
</div>


<h2>Kullanıcılar</h2>
<table id="usersTable">
  <thead>
    <tr><th>ID</th><th>Kullanıcı Adı</th><th>Email</th><th>İşlem</th></tr>
  </thead>
  <tbody>
    <?php if(!empty($users)): foreach($users as $user): ?>
      <tr id="user-<?= (int)$user['id'] ?>">
        <td><?= (int)$user['id'] ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td class="action">
          <button class="danger" onclick="deleteUser(<?= (int)$user['id'] ?>)">Sil</button>
          <button class="btn editUser" 
                  data-id="<?= $user['id'] ?>"
                  data-username="<?= htmlspecialchars($user['username']) ?>"
                  data-email="<?= htmlspecialchars($user['email']) ?>">
              Düzenle
          </button>
        </td>
      </tr>
    <?php endforeach; else: ?>
      <tr><td colspan="4">Hiç kullanıcı yok.</td></tr>
    <?php endif; ?>
  </tbody>
</table>

<!-- Modal kullanıcı -->
<div class="modal fade" id="editUserModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editUserForm">
        <div class="modal-header">
          <h5 class="modal-title">Kullanıcı Düzenle</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-user-id">
          <div class="form-group">
            <label>Kullanıcı Adı:</label>
            <input type="text" name="username" id="edit-username" class="form-control" required>
          </div>
          <div class="form-group">
            <label>E-Posta:</label>
            <input type="text" name="email" id="edit-email" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
          <button type="submit" class="btn btn-primary">Güncelle</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
//users DataTable olaşturma 
$(document).ready(function(){
  $('#usersTable').DataTable({
    language:{
      url:"https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json",
    },
    pageLength:10,
    lengthMenu:[5,10,25,50,100],
    ordering:true,
    searching:true,
    responsive:true
  })
})

//Product DataTable oluşturma
$(document).ready(function(){
  $('#productsTable').DataTable({
    language:{
      url:"https://cdn.datatables.net/plug-ins/1.13.6/i18n/tr.json"
    },
    pageLength:10,
    lengthMenu:[5,10,25,50,100],
    ordering:true,//sıralama acık
    searching:true,//arama acık
    responsive:true//mobil uyumluluk,
  });
});

//-----------------------------------------------
// ÜRÜN SİL (AJAX)
// ÜRÜN SİL (SweetAlert2 + AJAX)
function deleteProduct(id){
  Swal.fire({
    title: "Silmek istediğinize emin misiniz?",
    text: "Bu işlem geri alınamaz!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Evet, sil!",
    cancelButtonText: "İptal"
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('/php/php_calısmaları/eticaret-main/public/admin/deleteProduct/delete/' + id, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(r => r.json())
      .then(res => {
        if(res.success){
          const row = document.getElementById('product-'+id);
          if(row) row.remove();

          Swal.fire({
            title: "Silindi!",
            text: "Ürün başarıyla silindi.",
            icon: "success"
          });
        }else{
          Swal.fire({
            title: "Hata!",
            text: (res.errors && res.errors.join('\n')) || 'Silme işlemi başarısız.',
            icon: "error"
          });
        }
      })
      .catch(err => {
        console.error(err);
        Swal.fire({
          title: "Hata!",
          text: "Sunucuya ulaşılamadı.",
          icon: "error"
        });
      });
    }
  });
}




$(document).ready(function(){ //document ready olayı, sayfa tamamen yüklendiğinde tetiklenir ve içerisi çalışmaya başlar.
  $("#addProduct").click(function(e){
    e.preventDefault(); //bunun olayı çok elzem. ekstra farklı bir olayı tetiklemeden, dümdüz kendi istediğimi yani altındaki satırları çalıştırmasını istediğim için ekliyorum.
    $("#addProductModal").modal("show");  //modalı açar
  })
  //olur öyle şeyler xd

  $("#addProductForm").submit(function(event){
    event.preventDefault();
    let formData = new FormData(this);  //formu görsel ile birlikte toplayıp, formdata objesine dönüştürür.
    let formValues = $(this).serializeArray();  //formu görsel olmadan, düz objeye dönüştürür (bunu tabloya veriyi basmak için yaptım)
    //formdata data kontrolü yapılacak. boşsa veya required olması gereken veri yoksa hata toastr basılacak.

    $.ajax({  //nam-ı değer ajaxımız
      url: '/php/php_calısmaları/eticaret-main/public/admin/addProduct', 
      method: 'post',
      dataType:'json',  //giden request, dönen response için düz html yapı mı yoksa json yapı mı olduğunu belirtip, ona göre datayı beklersin iki tarafta da.
      data: formData, //buraya data:formData yazdım ama eğer tek tek verileri vermek istersen => data: {veri1: 11, veri2: "test"} şeklinde tanımlaman gerekir. eğer bu obje bir değişkendeyse, direkt formData gibi değişkeni dümdüz yazman yeterlidir.
      processData : false,  //image'ın düzgün yüklenmesini ve cache'te eskisinin kalmasını önler
      contentType : false, //image'ın düzgün yüklenmesini ve cache'te eskisinin kalmasını önler
      success: function(response) { //sonucun success olması önemli değil, sonucun 200 üzerinden bir kod ile dönmesi önemlidir burasının çalışması için.
        console.log("başarılı agacım", response); //response değeri ise, tamamen istekten dönen json objesini kullanman için gerekli.
        //1. adım modal ekledik++
        //2. adım ajax ile işlem yaptırdık sayfayı yenilemeden++
        //3. adım mesaj vericez kullanıcıya ++
        //4. adım tabloyu yenilicez eğer response success ise
        
        //3. adım
        toastSuccess("at yalanı", "dürteyim inananı") //bunu biliyon artık dimi , eşin dostun yoldaşın olacak bu 

        //4. adım
        /*
        <tr id="product-3">
        <td>3</td>
        <td></td>
        <td>0.00 ₺</td>
        <td></td>
        <td>0</td>
        <td class="action">
          <button class="danger" onclick="deleteProduct(3)">Sil</button>
          <a href="/php/php_calısmaları/eticaret-main/public/admin/editOrUpdateProduct/edit/3">Düzenle</a>
        </td>
      </tr>
      */

      //burda ise, css seçicisi gibi, jquery içinde de aynı şekilde seçici kullanarak hedef alanı belirtiyorum  => #productsTable tbody
      //tbody'nin en sonuna değer ekliyorum (append)
      //eklediğim değeri birebir <tr> <td> sayılarına göre ekliyorum.
      $("#productsTable tbody").append(`<tr id="product-${response.success}">
        <td>${response.success}</td>
        <td>${formValues[0].value}</td>
        <td>${formValues[1].value}₺</td>
        <td>${formValues[2].value}</td>
        <td>${formValues[3].value}</td>
        <td class="action">
          <button class="danger" onclick="deleteProduct(${response.success})">Sil</button>
          <a href="/php/php_calısmaları/eticaret-main/public/admin/editOrUpdateProduct/edit/${response.success}">Düzenle</a>
        </td>
      </tr>`);
      },
      error: function(response){  //data 200 dönmediyse veya beklediğimiz gibi (dataType:json) json dönmediyse burası çalışır.
        console.log("sss", response)
      }
    })
});
})
//-----------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------

//datadan cevap olarka aldık
// Ürün düzenleme modalı açma
$(document).on("click", ".editProduct", function() {
    let id = $(this).data("id");
    $("#edit-id").val(id);
    $("#edit-name").val($(this).data("name"));
    $("#edit-price").val($(this).data("price"));
    $("#edit-description").val($(this).data("description"));
    $("#edit-stock").val($(this).data("stock"));
    $("#edit-img").attr("src", "/php/php_calısmaları/eticaret-main/public/assets/upload/" + $(this).data("img"));

    $("#editProductModal").modal("show");
});

// Ürün düzenleme form submit
$("#editProductForm").submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = $("#edit-id").val();

    $.ajax({
        url: "/php/php_calısmaları/eticaret-main/public/admin/editOrUpdateProduct/edit/" + id,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(res) {
            if(res.success){
                // Tabloyu güncelle
                let tr = $("#product-" + id);
                tr.find("td:eq(1)").text(res.data.name);
                tr.find("td:eq(2)").text(res.data.price + " ₺");
                tr.find("td:eq(3)").text(res.data.description);
                tr.find("td:eq(4)").text(res.data.stock);
                tr.find(".editProduct").data("name", res.data.name)
                                       .data("price", res.data.price)
                                       .data("description", res.data.description)
                                       .data("stock", res.data.stock)
                                       .data("img", res.data.img);
//------------------------------------------------------//
                $("#editProductModal").modal("hide");
                // SweetAlert ile başarılı mesaj
                Swal.fire({
                    title: "Başarılı!",
                    text: "Ürün başarıyla güncellendi!",
                    icon: "success",
                    confirmButtonText: "Tamam"
                });

            } else {
                // Hata mesajı
                Swal.fire({
                    title: "Hata!",
                    text: res.message || "Güncelleme başarısız!",
                    icon: "error",
                    confirmButtonText: "Tamam"
                });
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            Swal.fire({
                title: "Hata!",
                text: "Ajax isteği başarısız!",
                icon: "error",
                confirmButtonText: "Tamam"
            });
        }
    });
});


//Modal aç..
// Düzenle butonuna tıklandığında modalı aç
// Kullanıcı düzenleme modalı açma
$(document).on("click", ".editUser", function() {
    let id = $(this).data("id");
    $("#edit-user-id").val(id);
    $("#edit-username").val($(this).data("username"));
    $("#edit-email").val($(this).data("email"));
    $("#editUserModal").modal("show");
});

// Form submit olunca AJAX ile güncelle
$("#editUserForm").submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = $("#edit-user-id").val();

    $.ajax({
        url: "/php/php_calısmaları/eticaret-main/public/admin/editOrUpdateUser/edit/" + id,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(res) {
            if(res.success){
                // Tabloyu güncelle
                let tr = $("#user-" + id);
                tr.find("td:eq(1)").text(res.data.username);
                tr.find("td:eq(2)").text(res.data.email);
                tr.find(".editUser").data("username", res.data.username)
                                    .data("email", res.data.email);

                $("#editUserModal").modal("hide");

                // SweetAlert başarılı mesaj
                Swal.fire({
                    title: "Başarılı!",
                    text: "Kullanıcı başarıyla güncellendi!",
                    icon: "success",
                    confirmButtonText: "Tamam"
                });

            } else {
                // Hata mesajı
                Swal.fire({
                    title: "Hata!",
                    text: res.message || "Güncelleme başarısız!",
                    icon: "error",
                    confirmButtonText: "Tamam"
                });
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            Swal.fire({
                title: "Hata!",
                text: "Ajax isteği başarısız!",
                icon: "error",
                confirmButtonText: "Tamam"
            });
        }
    });
});



// KULLANICI SİL (SweetAlert2 + AJAX + Toast)
function deleteUser(id){
  Swal.fire({
    title: "Kullanıcıyı silmek istediğinize emin misiniz?",
    text: "Bu işlem geri alınamaz!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Evet, sil!",
    cancelButtonText: "İptal"
  }).then((result) => {
    if (result.isConfirmed) {
      fetch('/php/php_calısmaları/eticaret-main/public/admin/deleteUser/delete/' + id, {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(r => r.json())
      .then(res => {
        if(res.success){
          $("#user-" + id).remove();
          toastSuccess("Başarılı", "Kullanıcı silindi!");
        } else {
          toastError("Hata", res.message || "Silme işlemi başarısız!");
        }
      })
      .catch(err => {
        console.error(err);
        toastError("Hata", "Sunucuya ulaşılamadı.");
      });
    }
  });
}




</script>
</body>
</html>

