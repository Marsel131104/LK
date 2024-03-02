<?php
session_start();
if (isset($_SESSION['users']) and (!in_array(session_id(), $_SESSION['users']))) {
    header("Location: index.php");
    die();
}


// изменение имени
if (isset($_POST['btn_name'])) {
    $name = $_POST['name'];
    echo $name;
    if (!$name) {
        header("Location: ../profile.php?accuracy_name");
        die();
    }
    function update_name($name)
    {
        require "../db/db_connect.php";
        $session_id = session_id();
        mysqli_query($lnk, "UPDATE users SET name = '$name' WHERE session_id = '$session_id'");
    }


    update_name($name);
    header("Location: ../profile.php?ok_name");
}


//изменение email
if (isset($_POST['btn_email'])) {
    $email = $_POST['email'];
    if (!$email) {
        header("Location: ../profile.php?accuracy_email");
        die();
    }

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


    $users = query_select();
    foreach ($users as $user) {
        if ($email == $user['email']) {
            header("Location: ../profile.php?person_email");
            die();
        }
    }

    function update_email($email)
    {
        require "../db/db_connect.php";
        $session_id = session_id();
        mysqli_query($lnk, "UPDATE users SET email = '$email' WHERE session_id = '$session_id'");
    }

    update_email($email);
    header("Location: ../profile.php?ok_email");


}



//изменение номера телефона
if (isset($_POST['btn_phone'])) {
    $phone = $_POST['phone'];
    if (!$phone) {
        header("Location: ../profile.php?accuracy_phone");
        die();
    }

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


    $users = query_select();
    foreach ($users as $user) {
        if (($phone == $user['phone']) and (session_id() != $user['session_id'])) {
            header("Location: ../profile.php?person_phone");
            die();
        }
    }


    function update_phone($phone)
    {
        require "../db/db_connect.php";
        $session_id = session_id();
        mysqli_query($lnk, "UPDATE users SET phone = '$phone' WHERE session_id = '$session_id'");
    }

    update_phone($phone);
    header("Location: ../profile.php?ok_phone");


}




// изменение пароля
if (isset($_POST['btn_password'])) {

    $old = $_POST['old'];
    $new = $_POST['new'];

    if ((!$old) or (!$new)) {
        header("Location: ../profile.php?accuracy_password");
        die();
    }

    if ($old == $new) {
        header("Location: ../profile.php?identically_password");
        die();
    }

    function query_select()
    {
        require "../db/db_connect.php";
        $session_id = session_id();
        $row = mysqli_fetch_assoc(mysqli_query($lnk, "SELECT password FROM users WHERE session_id = '$session_id'"));
        return $row['password'];
    }

    if (!password_verify($old, query_select())) {
        header("Location: ../profile.php?old_err_password");
        die();
    }



    function update_password($new)
    {
        require "../db/db_connect.php";
        $session_id = session_id();
        mysqli_query($lnk, "UPDATE users SET password = '$new' WHERE session_id = '$session_id'");
    }

    $str_low = "qwertyuiopasdfghjklzxcvbnm";
    $str_high = "QWERTYUIOPASDFGHJKLZXCVBNM";
    $str_sybmols = "!#$%&\'()*+,-./:;<=>?@[\]^_`{|}~";
    $flag_low = false;
    $flag_high = false;
    $flag_symbols = false;


    for ($i = 0; $i < strlen($new); $i++) {
        if (($flag_low) and ($flag_high) and ($flag_symbols)) {
            break;
        }
        else if (strpos($str_low, $new[$i]))
            $flag_low = true;
        else if (strpos($str_high, $new[$i]))
            $flag_high = true;
        else if (strpos($str_sybmols, $new[$i]))
            $flag_symbols = true;
    }

    if (($flag_low) and ($flag_high) and ($flag_symbols)) {
        $new = password_hash($new, PASSWORD_DEFAULT);
        update_password($new);
        header("Location: ../profile.php?ok_password");
        die();
    } else header("Location: ../profile.php?new_err_password");
}






