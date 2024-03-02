<?php
session_start();



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма авторизации</title>
    <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center; /* Центрирование содержимого по горизонтали */
            align-items: center; /* Центрирование содержимого по вертикали */
            height: 100vh; /* Для центрирования по вертикали */
        }
        .registration-form {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .registration-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        .registration-form button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body style="background-color: #a1a5a3">

<div class="registration-form" style="background-color: #abf5d3">
    <h2 style="text-align: center">Вход</h2>
    <form method="POST" action="controllers/check.php" style="margin-top: 20px;" >
        <input type="text" name="email" placeholder="Телефон / Email">
        <input type="password" name="password" placeholder="Пароль">
        <button type="submit">Войти</button>

        <?php

        if (isset($_GET['captcha']))
            echo '<i style="margin-top: 20px; color: #cc4545">Подтвердите, что вы не робот</i>';

        else if (isset($_GET['accuracy']))
            echo '<i style="margin-top: 20px; color: #cc4545">Заполните все поля</i>';

        else if (isset($_GET['person']))
            echo '<i style="margin-top: 20px; color: #cc4545">Такого пользователя не существует</i>';

        else if (isset($_GET['password']))
            echo '<i style="margin-top: 20px; color: #cc4545">Неверный пароль</i>';

        ?>


        <div
                id="captcha-container"

                name="capcha"
                style="margin-top: 20px"
                class="smart-captcha"
                data-sitekey="ysc1_I6eXJMHSu0yubAqpSnrsgFA9qEntOnZzEhRDXRBS97a21877"
                data-hl="ru"
        >
            <input type="hidden" name="smart-token">
        </div>
        <p style="margin-top: 20px; text-align: center"><a href="index.php" class="link-secondary">Зарегистрироваться</a></p>
    </form>
</div>

</body>
</html>
