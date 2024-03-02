<?php
session_start();
if (isset($_SESSION['users']) and (!in_array(session_id(), $_SESSION['users']))) {
    header("Location: index.php");
    die();
}


require "db/db_connect.php";
$session_id = session_id();
$row = mysqli_fetch_assoc(mysqli_query($lnk, "SELECT * FROM users WHERE session_id = '$session_id'"));
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <title>Личный кабинет</title>

</head>
<body style="background-color: #a1a5a3">

<p style="text-align: right; margin-right: 20px; margin-top: 20px"><a href="controllers/logout.php" class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" >Выйти</a></p>

<h4 style="text-align: center; margin-top: 5%"><span class="badge text-bg-warning">Личный кабинет</span></h4>
<table class="table table-striped-columns" style="text-align: center; width: 100%; margin: 0 auto; margin-top: 50px;">
    <thead>
    <tr>
        <th scope="col">Имя</th>
        <th scope="col">Email</th>
        <th scope="col">Номер телефона</th>
        <th scope="col">Сменить пароль</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row"><?= $row['name']?>
            <div class="input-group">
                <form style="display: flex; margin: 0 auto;" method="POST" action="controllers/change.php">
                    <input name="name" type="text" class="form-control" placeholder="Имя" style="text-align: center">
                    <button name="btn_name" class="btn btn-outline-secondary" type="submit" id="button-addon2">Изменить</button>
                </form>

                <?php

                if (isset($_GET['accuracy_name']))
                    echo '<i style="margin-top: 20px; color: #cc4545; margin: 0 auto">Заполните все поля</i>';

                else if (isset($_GET['ok_name']))
                    echo '<i style="margin-top: 20px; color: #1dec0b; margin: 0 auto">Ваше имя успешно изменено</i>';
                ?>

            </div>


        </th>
        <td><?= $row['email']?>
            <div class="input-group">
                <form style="display: flex; margin: 0 auto;" method="POST" action="controllers/change.php">
                    <input name="email" type="email" class="form-control" placeholder="Email" style="text-align: center">
                    <button name="btn_email" class="btn btn-outline-secondary" type="submit" id="button-addon2">Изменить</button>
                </form>

                <?php

                if (isset($_GET['accuracy_email']))
                    echo '<i style="margin-top: 20px; color: #cc4545; margin: 0 auto">Заполните все поля</i>';

                else if (isset($_GET['incorrect_email']))
                    echo '<i style="margin-top: 20px; color: #cc4545;  margin: 0 auto">Пропущено: "@"</i>';

                else if (isset($_GET['person_email']))
                    echo '<i style="margin-top: 20px; color: #cc4545; margin: 0 auto">Такой пользователь уже существует</i>';

                else if (isset($_GET['ok_email']))
                    echo '<i style="margin-top: 20px; color: #1dec0b; margin: 0 auto">Ваш email успешно изменён</i>';
                ?>

            </div>
        </td>




        <td><?= $row['phone']?>
            <div class="input-group">
                <form style="display: flex; margin: 0 auto;" method="POST" action="controllers/change.php">
                    <input name="phone" type="text" class="form-control" placeholder="Номер телефона" style="text-align: center">
                    <button name="btn_phone" class="btn btn-outline-secondary" type="submit" id="button-addon2">Изменить</button>
                </form>

                <?php

                if (isset($_GET['accuracy_phone']))
                    echo '<i style="margin-top: 20px; color: #cc4545; margin: 0 auto">Заполните все поля</i>';

                else if (isset($_GET['person_phone']))
                    echo '<i style="margin-top: 20px; color: #cc4545;  margin: 0 auto">Этот номер используется другим аккаунтом</i>';

                else if (isset($_GET['ok_phone']))
                    echo '<i style="margin-top: 20px; color: #1dec0b; margin: 0 auto">Ваш номер телефона успешно изменён</i>';
                ?>

            </div>
        </td>



        <td>
            <div class="input-group">
                <form style="display: flex; margin: 0 auto" method="POST" action="controllers/change.php">
                <input name="old" type="password" class="form-control" placeholder="Старый пароль" style="text-align: center">
                <input name="new" type="password" minlength="5" class="form-control" placeholder="Новый пароль" style="text-align: center">
                <button name="btn_password" class="btn btn-outline-secondary" type="submit" id="button-addon2">Сменить</button>
                </form>

                <?php

                if (isset($_GET['accuracy_password']))
                    echo '<i style="margin-top: 20px; color: #cc4545; margin: 0 auto">Заполните все поля</i>';

                else if (isset($_GET['identically_password']))
                    echo '<i style="margin-top: 20px; color: #cc4545;  margin: 0 auto">Новый пароль должен отличаться от старого</i>';

                else if (isset($_GET['old_err_password']))
                    echo '<i style="margin-top: 20px; color: #cc4545; margin: 0 auto">Старый пароль неверный</i>';

                else if (isset($_GET['new_err_password']))
                    echo '<i style="margin-top: 20px; color: #cc4545; margin: 0 auto">Пароль должен состоять минимум из 5 символов и содеражть в себе букву(ы) нижнего и верхнего регистра, а также специальный(ые) символ</i>';

                else if (isset($_GET['ok_password']))
                    echo '<i style="margin-top: 20px; color: #1dec0b; margin: 0 auto">Ваш пароль успешно изменён</i>';
                ?>

            </div>

        </td>
    </tr>
</table>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
