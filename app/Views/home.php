<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* GENEL GÖRÜNÜM */
        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
            color: #333;
            transition: background 0.3s ease, color 0.3s ease;
        }

        body.dark-mode {
            background: #121212;
            color: #e0e0e0;
        }

        /* HEADER */
        header {
            background: linear-gradient(135deg, #4b6cb7, #182848);
            color: #fff;
            padding: 18px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.25);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .cart {
            position: relative;
            cursor: pointer;
        }

        .cart svg {
            color: white;
            font-size: 28px;
            transition: transform 0.25s ease;
        }

        .cart:hover svg {
            transform: scale(1.2);
        }

        .cart span {
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            padding: 3px 8px;
            position: absolute;
            top: -10px;
            right: -10px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }

        /* TEME BUTONU */
        #theme-toggle {
            position: fixed;
            left: 25px;
            bottom: 25px;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            border: none;
            padding: 14px 18px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 22px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.35);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        #theme-toggle:hover {
            transform: scale(1.25) rotate(15deg);
            box-shadow: 0 10px 25px rgba(0,0,0,0.45);
        }

        /* KAMPANYA BANNER */
        .campaign-banner {
            background: linear-gradient(135deg, #f39c12, #e67e22);
            color: white;
            text-align: center;
            padding: 12px;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            animation: slideDown 0.5s ease-in-out;
            box-shadow: 0 3px 12px rgba(0,0,0,0.2);
        }

        @keyframes slideDown {
            from { transform: translateY(-120%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* ÜRÜNLER */
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            padding: 40px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            position: relative;
        }

        body.dark-mode .card {
            background: #1e1e2f;
        }

        .card:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 16px 32px rgba(0,0,0,0.25);
        }

        .card img {
            width: 100%;
            height: 230px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .card:hover img {
            transform: scale(1.08);
        }

        .card-content {
            padding: 18px 16px 22px;
        }

        .card h3 {
            margin: 0 0 8px;
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
        }

        body.dark-mode .card h3 {
            color: #f1f1f1;
        }

        .card p {
            margin: 0 0 6px;
            font-size: 14px;
            color: #555;
        }

        body.dark-mode .card p {
            color: #bbb;
        }

        .price {
            font-weight: 700;
            font-size: 18px;
            color: #27ae60;
            margin-top: 5px;
        }

        .btn {
            display: block;
            text-align: center;
            margin-top: 15px;
            padding: 12px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .btn:hover {
            background: linear-gradient(135deg, #1f4e73, #1a3b5d);
            transform: scale(1.05);
        }

        .btn.disabled {
            background: #999;
            pointer-events: none;
        }

        /* TOOLTIP */
        .tooltip {
            display: none;
            position: absolute;
            bottom: 85px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.9);
            color: #fff;
            padding: 10px 16px;
            border-radius: 12px;
            font-size: 13px;
            width: 90%;
            text-align: center;
            z-index: 10;
            box-shadow: 0 6px 16px rgba(0,0,0,0.3);
        }

        .card:hover .tooltip {
            display: block;
            animation: fadeIn 0.35s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -15px); }
            to { opacity: 1; transform: translate(-50%, 0); }
        }
        .logout-btn {
            background: linear-gradient(135deg, #3498db, #2980b9); /* mavi tonları */
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #e63946, #b71c1c); /* kırmızı tonları */
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 18px rgba(0,0,0,0.35);
        }

    </style>
</head>
<body>

<header>
    <h1>E-Ticaret Sitesi</h1>

    <div style="display:flex; align-items:center; gap:20px;">
        <?php if(!empty($_SESSION['user_logged'])):?>
            <button id="logoutid" class="logout-btn">Çıkış Yap</button>
        <?php endif;?>
            <div class="cart" onclick="window.location.href='/php/php_calısmaları/eticaret-main/cart'">
                 <?php if(!empty($_SESSION['user_logged'])):?> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M0 1a1 1 0 0 1 1-1h1.5a.5.5 0 0 1 .485.379L3.89 5H14.5a.5.5 0 0 1 .49.598l-1.5 7A.5.5 0 0 1 13 13H4a.5.5 0 0 1-.49-.402L1.61 2H1a1 1 0 0 1-1-1z"/>
                        <path d="M5 16a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm7 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                    </svg>
                <?php endif; ?>
            <?php if(!empty($_SESSION['user_logged'])):?>
                <span id="cart-count"><?= $_SESSION['cart_count'] ?? 0 ?></span>
            <?php endif; ?>
        </div>
    </div>
</header>

<?php if (!empty($_SESSION['user_logged'])): ?>
    <div class="campaign-banner">
        🎁 Hoş geldin! Bugün sepette %10 indirim seni bekliyor!
    </div>
<?php endif; ?>

<main>
    <section class="products">
        <?php foreach($products as $urun): ?>
            <div class="card">
                <a href="/php/php_calısmaları/eticaret-main/product/detail/<?= htmlspecialchars($urun['id'])?>">
                    <img src="/php/php_calısmaları/eticaret-main/public/assets/upload/<?= htmlspecialchars($urun['img']) ?>" alt="<?= htmlspecialchars($urun['name']) ?>">
                </a>
                <div class="tooltip"><?= htmlspecialchars($urun['description']) ?></div>
                <div class="card-content">
                    <h3><?= htmlspecialchars($urun['name']) ?></h3>
                    <p><strong>Stok:</strong> <?= number_format($urun['stock']) ?></p>
                    <div class="price"><?= number_format($urun['price'],2) ?> ₺</div>

                    <?php if ($urun['stock'] > 0): ?>
                        <?php if (!empty($_SESSION['user_logged'])): ?>

                            <button class="btn add-to-cart" data-id="<?= $urun['id'] ?>">Sepete Ekle</button>
                        <?php else: ?>
                            <a href="/php/php_calısmaları/eticaret-main/auth/login" class="btn">Giriş Yap ve Sepete Ekle</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="btn disabled">Stokta Yok</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

    </section>
</main>

<button id="theme-toggle">🌙</button>

<script>
document.getElementById("logoutid").addEventListener("click",function(){
    window.location.href="/php/php_calısmaları/eticaret-main/auth/logout"
})

toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "1500"
};

$(document).ready(function(){
    $("#theme-toggle").on("click", function(){
        $("body").toggleClass("dark-mode");
        const mode = $("body").hasClass("dark-mode") ? "Koyu mod aktif" : "Açık mod aktif";
        toastr.info(mode);
    });

    $(".add-to-cart").on("click", function(){
        let btn = $(this);
        let id = btn.data("id");
        btn.text("Ekleniyor...").prop("disabled", true);

        $.ajax({
            url: "/php/php_calısmaları/eticaret-main/cart/add/" + id,
            type: "GET",
            dataType: "json",
            success: function(data){
                btn.text("Sepete Ekle").prop("disabled", false);
                if(data.success){
                    $("#cart-count").text(data.cart_count);
                    toastr.success("Ürün sepete eklendi!");
                } else {
                    toastr.warning("Ürün sepete eklenemedi!");
                }
            },
            error: function(xhr, status, error){
                btn.text("Sepete Ekle").prop("disabled", false);
                console.error(error);
                toastr.error("Bir hata oluştu. Lütfen tekrar deneyin.");
            }
        });
    });
});
</script>

</body>
</html>
