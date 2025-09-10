<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sepetim</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin:0; padding:0;
            background:#f4f6f9;
        }
        header {
            background:#2c3e50;
            color:#fff;
            padding:15px 40px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        header h1 { margin:0; font-size:26px; font-weight:bold; }
        .cart a { color:white; text-decoration:none; font-size:24px; }

        .products {
            display:grid;
            grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
            gap:25px;
            padding:30px;
        }
        .card {
            background:white; border-radius:12px;
            box-shadow:0 4px 15px rgba(0,0,0,0.1);
            overflow:hidden; transition:transform 0.2s, box-shadow 0.2s;
            position:relative;
        }
        .card:hover { transform:translateY(-5px); box-shadow:0 6px 20px rgba(0,0,0,0.2); }
        .card img { width:100%; height:220px; object-fit:cover; }
        .card-content { padding:15px; }
        .card h3 { margin:0 0 10px; font-size:18px; }
        .price { font-weight:bold; font-size:16px; color:#27ae60; }

        .adet-controls {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
        }
        .adet-controls button {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 50%;
            background-color: #f0f0f0;
            color: #333;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .adet-controls button:hover {
            background-color: #ff6f00;
            color: #fff;
            transform: scale(1.05);
        }
        .adet-controls .remove {
            background-color: #ffecec;
            color: #d32f2f;
            font-size: 20px;
            border-radius: 8px;
            padding: 0 10px;
            width: auto;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .adet-controls .remove:hover {
            background-color: #d32f2f;
            color: #fff;
        }

        .select-product {
            position: absolute;
            top: 10px;
            left: 10px;
            transform: scale(1.3);
        }

        .order-summary {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            border-radius: 12px;
            padding: 20px;
            z-index: 999;
            width: 240px;
        }
        .order-summary .totals p {
            margin: 8px 0;
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
        }
        .order-summary button {
            margin-top: 10px;
            width: 100%;
            padding: 10px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .order-summary button:hover {
            background-color: #219150;
        }
    </style>
</head>
<body>

<header>
    <h1>Sepetim</h1>
    <div class="cart">
        <a href="/php/php_calısmaları/eticaret-main/home">🏠</a>
    </div>
</header>

<main>
<section class="products">
    <?php if (empty($cart)): ?>
        <p>Sepetiniz boş.</p>
    <?php else: ?>
        <?php foreach($cart as $urun): ?>
            <div class="card" data-id="<?= $urun['id'] ?>" data-price="<?= $urun['price'] ?>" data-adet="<?= $urun['adet'] ?>">
                <input type="checkbox" class="select-product">
                <img src="/php/php_calısmaları/eticaret-main/public/assets/upload/<?= htmlspecialchars($urun['img']) ?>" alt="<?= htmlspecialchars($urun['name']) ?>">
                <div class="card-content">
                    <h3><?= htmlspecialchars($urun['name']) ?></h3>
                    <div class="price"><?= number_format($urun['price'] * $urun['adet'], 2) ?> ₺</div>
                    <div class="adet-controls">
                        <button class="minus">-</button>
                        <span class="adet">Adet: <?= $urun['adet'] ?></span>
                        <button class="plus">+</button>
                        <button class="remove">🗑️</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<div class="order-summary">
    <div class="totals">
        <p>KDV Hariç: <span id="kdvsiz-toplam">0.00 ₺</span></p>
        <p>KDV Dahil: <span id="kdvli-toplam">0.00 ₺</span></p>
    </div>
    <button id="siparis-ver">Siparişi Ver</button>
</div>

<script>
$(document).ready(function () {
    // Toplamları güncelle
    function updateSummary() {
        let kdvsiz = 0;
        $('.select-product:checked').each(function () {
            const card = $(this).closest('.card');
            const adet = card.data('adet'); // jQuery cache'ten oku
            const price = card.data('price');
            kdvsiz += price * adet;
        });
        const kdvli = kdvsiz * 1.20;
        $('#kdvsiz-toplam').text(kdvsiz.toFixed(2) + ' ₺');
        $('#kdvli-toplam').text(kdvli.toFixed(2) + ' ₺');
    }

    // Checkbox değişince toplamları güncelle
    $('.select-product').on('change', updateSummary);

    // Adet artır/azalt
    $('.plus, .minus').on('click', function () {
        const card = $(this).closest('.card');
        const urunId = card.data('id');
        const pricePerUnit = parseFloat(card.data('price'));
        let adetElem = card.find('.adet');
        let adet = parseInt(adetElem.text().split(':')[1].trim());

        if ($(this).hasClass('plus')) {
            adet += 1;
        } else {
            adet = Math.max(1, adet - 1);
        }

        // DOM güncelle
        adetElem.text('Adet: ' + adet);
        card.find('.price').text((pricePerUnit * adet).toFixed(2) + ' ₺');
        card.attr('data-adet', adet);
        card.data('adet', adet); // jQuery cache'i de güncelle

        // Backend'e gönder
        $.post('/php/php_calısmaları/eticaret-main/cart/update', { id: urunId, adet: adet });

        updateSummary();
    });

    // Ürün sil
    $('.remove').click(function () {
        const card = $(this).closest('.card');
        const urunId = card.data('id');

        $.post('/php/php_calısmaları/eticaret-main/cart/remove', { id: urunId }, function () {
            card.fadeOut();
            updateSummary();
        });
    });

    // Siparişi ver
    $('#siparis-ver').click(function () {
        const selected = [];
        $('.select-product:checked').each(function () {
            const card = $(this).closest('.card');
            selected.push({
                id: card.data('id'),
                adet: card.data('adet'),
                price: card.data('price'),
                name: card.find("h3").text() 
            });
        });

        if (selected.length === 0) {
            toastr.warning("Lütfen sipariş vermek için ürün seçin.");
            return;
        }

        const kdvsiz = selected.reduce((sum, p) => sum + p.price * p.adet, 0);
        const kdvli = kdvsiz * 1.20;

        Swal.fire({
            title: "Sipariş Onayı",
            html: `<b>KDV Hariç:</b> ${kdvsiz.toFixed(2)} ₺<br><b>KDV Dahil:</b> ${kdvli.toFixed(2)} ₺`,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Siparişi Ver",
            cancelButtonText: "İptal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/php/php_calısmaları/eticaret-main/cart/bulkOrder',
                    type: 'POST',
                    data: { products: selected }, // JSON.stringify değil
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            Swal.fire("Başarılı!", response.message, "success");
                            $('.select-product:checked').closest('.card').fadeOut();
                            $('#kdvsiz-toplam').text('0.00 ₺');
                            $('#kdvli-toplam').text('0.00 ₺');
                        } else {
                            Swal.fire("Hata!", response.message, "error");
                        }
                    },
                    error: function () {
                        Swal.fire("Hata!", "Sipariş gönderilemedi.", "error");
                    }
                });
            }
        });
    });
});
</script>


</script>
</body>
</html>
