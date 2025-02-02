<?php
    $name = $_POST['name'];
    $nickname = $_POST['nickname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $registration_date = date("Y-m-d");
    $user_settings = $_POST['user_settings'];

    $host = "localhost";
    $user = "root";
    $pw = "";

    $dbcon = mysqli_connect($host, $user, $pw);
    mysqli_select_db($dbcon, "bdguide");
    $dbcon->set_charset("utf8");

    if (mysqli_connect_errno()) {
        echo mysqli_connect_errno();
    }

    $sql = "insert into member(user_id, userpassword, username, useremail, user_settings, registration_date) ";
    $sql = $sql . "values('$name', '$password', '$nickname', '$email', '$user_settings', '$registration_date')";

    $result = mysqli_query($dbcon, $sql);
    
    if ($result) {
        echo "<script>alert('회원가입에 성공했습니다.'); location.href='../index.php';</script>";
        exit;
    } else {
        echo "<script>alert('회원가입에 실패했습니다.'); history.back();</script>";
    }

    mysqli_close($dbcon);
?>
