<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürünler</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            padding: 0;
            list-style: none;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-list li {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product-list li:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .product-list a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            font-weight: bold;
            display: block;
            transition: color 0.3s ease;
        }

        .product-list a:hover {
            color: #667eea;
        }

        .price {
            display: block;
            margin-top: 10px;
            font-size: 16px;
            color: #27ae60;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Ürünler</h2>
    <ul class="product-list">
        <?php foreach(($products ?? []) as $urun):?>
            <li>
                <a href="/eticaret-main/product/detail/<?= htmlspecialchars((string)$urun['id']) ?>">
                    <?= htmlspecialchars($urun['name'])?>
                </a>
                <span class="price"><?= htmlspecialchars($urun['price'])?> TL</span>
            </li>
        <?php endforeach ?>
    </ul>
</body>
</html>
