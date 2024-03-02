<?php
session_start();


$username = $_POST['username'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$double_password = $_POST['double_password'];

$captcha = $_POST['smart-token'];

$url = "https://smartcaptcha.yandexcloud.net/validate?secret=ysc2_I6eXJMHSu0yubAqpSnrsmb9wcFgVf0a7hYLpRhcPbae675f3&token=".$captcha;
$response = file_get_contents($url);

if (json_decode($response, true)['status'] != 'ok')
    header("Location: ../index.php?captcha");

else if ((!$username) or (!$phone) or (!$email) or (!$password))
    header("Location: ../index.php?accuracy");

else {

    function query_select()
    {
        require "../db/db_connect.php";
        $result = mysqli_query($lnk, "SELECT * FROM users");
        $items = array();
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($items, $row);
        }

        return $items;
    }

    function add($username, $email, $phone, $password)
    {
        require "../db/db_connect.php";
        mysqli_query($lnk, "INSERT INTO users (name, email, phone, password) VALUES ('$username', '$email', '$phone', '$password')");

    }


    $users = query_select();
    foreach ($users as $user) {
        if (($email == $user['email']) or ($phone == $user['phone'])) {
            header("Location: ../index.php?person");
            die();
        }
    }

    if ($password != $double_password) {
        header("Location: ../index.php?double_password");
        die();
    }



    $str_low = "qwertyuiopasdfghjklzxcvbnm";
    $str_high = "QWERTYUIOPASDFGHJKLZXCVBNM";
    $str_sybmols = "!#$%&\'()*+,-./:;<=>?@[\]^_`{|}~";
    $flag_low = false;
    $flag_high = false;
    $flag_symbols = false;


    for ($i = 0; $i < strlen($password); $i++) {
        if (($flag_low) and ($flag_high) and ($flag_symbols)) {
            break;
        }
        else if (strpos($str_low, $password[$i]))
            $flag_low = true;
        else if (strpos($str_high, $password[$i]))
            $flag_high = true;
        else if (strpos($str_sybmols, $password[$i]))
            $flag_symbols = true;
    }



    if (($flag_low) and ($flag_high) and ($flag_symbols)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        add($username, $email, $phone, $password);


        header("Location: ../login.php");
        die();
    }

    header("Location: ../index.php?password");

}











