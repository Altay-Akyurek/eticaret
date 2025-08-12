<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <h2>Ürünler</h2>
    <ul>
        <?php foreach($product as $urun):?>
            <li>
                <a href="/product/detail/<?=$urun['id'] ?>">
                    <?= htmlspecialchars($urun['name'])?>-<?= htmlspecialchars($urun['price'])?> TL
                </a>
            </li>
            <?php endforeach?>
    </ul>
    
</body>
</html>