<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$captcha = $_POST['smart-token'];

$url = "https://smartcaptcha.yandexcloud.net/validate?secret=ysc2_I6eXJMHSu0yubAqpSnrsmb9wcFgVf0a7hYLpRhcPbae675f3&token=".$captcha;
$response = file_get_contents($url);

if (json_decode($response, true)['status'] != 'ok')
    header("Location: ../login.php?captcha");

else if ((!$email) or (!$password))
    header("Location: ../login.php?accuracy");

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


    function update_session_id($email)
    {
        require "../db/db_connect.php";
        $session_id = session_id();

        mysqli_query($lnk, "UPDATE users SET session_id = '' WHERE session_id = '$session_id'");
        mysqli_query($lnk, "UPDATE users SET session_id = '$session_id' WHERE email = '$email' OR phone = '$email'");
    }

    function add_session_id($email)
    {
        require "../db/db_connect.php";
        $session_id = session_id();
        mysqli_query($lnk, "UPDATE users SET session_id = '$session_id' WHERE email = '$email' OR phone = '$email'");
    }



    $users = query_select();
    foreach ($users as $user) {
        if ((($email == $user['email']) or ($email == $user['phone'])) and (password_verify($password, $user["password"]))) {

            if (isset($_SESSION['users']) and (in_array(session_id(), $_SESSION['users'])))
                update_session_id($email);
            else {
                $_SESSION['users'][] = session_id();
                add_session_id($email);
            }

            header("Location: ../profile.php");
            die();
        }
    }
    header("Location: ../login.php?person");
    die();

}











