<?php
session_start();
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pw = "";

$dbcon = mysqli_connect($host, $user, $pw);
mysqli_select_db($dbcon, "bdguide");
$dbcon->set_charset("utf8");

$response = array("isDuplicate" => false);

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $sql = "SELECT COUNT(*) as count FROM member WHERE user_id = '$username'";
    $result = mysqli_query($dbcon, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['count'] > 0) {
        $response["isDuplicate"] = true;
    }
} else if (isset($_GET['useremail'])) {
    $email = $_GET['useremail'];
    $sql = "SELECT COUNT(*) as count FROM member WHERE useremail = '$email'";
    $result = mysqli_query($dbcon, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row['count'] > 0) {
        $response["isDuplicate"] = true;
    }
}

echo json_encode($response);
mysqli_close($dbcon);

?>