<?php

$lnk = mysqli_connect("localhost", "root", "", "test") or die('Cannot connect to server');
mysqli_select_db($lnk, "test") or die('Cannot open database');