<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма регистрации</title>
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
    <h2 style="text-align: center">Регистрация</h2>
    <form method="POST" action="controllers/create.php" style="margin-top: 20px;" >
        <input type="text" name="username" placeholder="Имя пользователя">
        <input type="tel" name="phone" placeholder="Номер телефона" >
        <input type="email" name="email" placeholder="Email">
        <input type="password" minlength="5" name="password" placeholder="Пароль">
        <input type="password" name="double_password" placeholder="Повторный пароль">
        <button type="submit">Зарегистрироваться</button>

        <?php

        if (isset($_GET['captcha']))
            echo '<i style="margin-top: 20px; color: #cc4545">Подтвердите, что вы не робот</i>';

        else if (isset($_GET['accuracy']))
            echo '<i style="margin-top: 20px; color: #cc4545">Заполните все поля</i>';

        else if (isset($_GET['person']))
            echo '<i style="margin-top: 20px; color: #cc4545">Такой пользователь уже существует</i>';

        else if (isset($_GET['double_password']))
            echo '<i style="margin-top: 20px; color: #cc4545">Пароли не совпадают</i>';

        else if (isset($_GET['password']))
            echo '<i style="margin-top: 20px; color: #cc4545">Пароль должен состоять минимум из 5 символов и содеражть в себе букву(ы) нижнего и верхнего регистра, а также специальный(ые) символ</i>';

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

        <p style="margin-top: 20px; text-align: center"><a href="login.php" class="link-secondary">Войти</a></p>
    </form>
</div>

</body>
</html>
