<?php
// Hata gösterimi (sadece geliştirme ortamında)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// $error değişkeni tanımlı değilse boş dizi yap
$error = $error ?? [];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 1s ease;
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: #333;
            font-size: 28px;
        }

        .error-list {
            text-align: left;
            margin-bottom: 15px;
        }
        .error-list li {
            color: #e74c3c;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 8px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .login-container input:focus {
            border-color: #667eea;
            box-shadow: 0 0 5px #667eea;
            outline: none;
        }

        .login-container button {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .login-container button:hover {
            background: #764ba2;
            transform: scale(1.05);
        }

        .login-container a {
            display: block;
            margin-top: 15px;
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .login-container a:hover {
            color: #764ba2;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        #response {
            margin-bottom: 15px;
            color: #e74c3c;
            font-weight: bold;
            text-align: left;
        }

        #registerid {
        display: inline-block;
        width: 100%;
        margin-top: 10px;
        padding: 12px 1px;
        border-radius: 8px;
        background-color: #00acc1; /* Mavi buton */
        color: #fff;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    #registerid:hover {
        background-color: #0dd2e8ff; /* Hover mavi ton */
        transform: scale(1.05);
    }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Giriş Yap</h2>

        <?php if (!empty($error)): ?>
            <ul class="error-list">
                <?php foreach ($error as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div id="response"></div>

        <form id="loginForm" method="POST" action="/php/php_calısmaları/eticaret-main/auth/login">
            <input type="email" name="email" placeholder="E-Posta" required>
            <input type="password" name="password" placeholder="Şifre" required>
            <button type="submit">Giriş Yap</button>
            <a id="registerid" class="logout-btn">Kayıt Ol</a>
        </form>

<div id="response"></div>

<script>
document.getElementById("registerid").addEventListener("click",function(){
    window.location.href="/php/php_calısmaları/eticaret-main/register/store"
})

document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);

    fetch(form.action, {
        method: "POST",
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(res => {
        if(res.success && res.redirect){
            window.location.href = res.redirect;
        } else if(res.errors){
            document.getElementById("response").innerHTML = res.errors.join("<br>");
        }
    })
    .catch(err => {
        console.error(err);
        document.getElementById("response").innerHTML = "Bir hata oluştu. Lütfen tekrar deneyin.";
    });
});
</script>

</body>
</html>
