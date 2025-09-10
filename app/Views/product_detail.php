<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Detayı</title>
    <style>
        body { font-family:'Segoe UI', Tahoma, sans-serif; margin:0; padding:0; background:#f4f6f9; }
        header { background:#2c3e50; color:#fff; padding:15px 40px; display:flex; justify-content:space-between; align-items:center; }
        header h1 { margin:0; font-size:26px; font-weight:bold; }
        .product-detail { max-width:600px; margin:0 auto; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); text-align:center; }
        img { max-width:100%; border-radius:8px; margin-bottom:15px; }
        .price { color:#27ae60; font-weight:bold; font-size:18px; margin-bottom:10px; }
        input { width:60px; padding:5px; margin-bottom:10px; text-align:center; }
        .btn { padding:10px 15px; background:#3498db; color:white; border:none; border-radius:6px; cursor:pointer; }
        .btn:hover { background:#2980b9; }
        .cart { position:relative; cursor:pointer; }
        .cart a { color:white; text-decoration:none; font-size:24px; }
        .cart span { background:red; color:white; border-radius:50%; padding:2px 7px; position:absolute; top:-8px; right:-10px; font-size:14px; font-weight:bold; }    </style>
</head>
<body>
    

<header>
    <h1>E-Ticaret Sitesi</h1>
    <div class="cart" onclick="window.location.href='/php/php_calısmaları/eticaret-main/cart'">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
            <path d="M0 1a1 1 0 0 1 1-1h1.5a.5.5 0 0 1 .485.379L3.89 5H14.5a.5.5 0 0 1 .49.598l-1.5 7A.5.5 0 0 1 13 13H4a.5.5 0 0 1-.49-.402L1.61 2H1a1 1 0 0 1-1-1z"/>
            <path d="M5 16a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm7 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
        </svg>
        <span id="cart-count"><?= $_SESSION['cart_count'] ?? 0 ?></span>
    </div>
</header>

<?php if (!empty($product)): ?>
    <div class="product-detail">
    <h2><?= htmlspecialchars($product['name']) ?></h2>
    <img src="/php/php_calısmaları/eticaret-main/public/assets/upload/<?= htmlspecialchars($product['img']) ?>" 
         alt="<?= htmlspecialchars($product['name']) ?>">
    <p class="price"><?= htmlspecialchars($product['price']) ?> TL</p>
    <p>Stok: <?= htmlspecialchars($product['stock']) ?></p>
    
    <h3><?= htmlspecialchars($product['description'])?></h3>
    
    <button class="btn" onclick="window.location.href='/php/php_calısmaları/eticaret-main/home'">← Geri Dön</button>
</div>

<?php else: ?>
    <p>Ürün bulunamadı.</p>
<?php endif; ?>

<script>
document.getElementById('addToCart')?.addEventListener('click', function(){
    const id = this.dataset.id;

    fetch(`/php/php_calısmaları/eticaret-main/cart/add/${id}`, {
        headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            document.getElementById('cart-count').textContent = data.cart_count;
            alert('Ürün sepete eklendi!');
        } else {
            alert('Sepete eklenemedi.');
        }
    });
});
</script>

</body>
</html>
