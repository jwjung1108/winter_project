<?php
session_start();
$sql = "select point from users where id = '$userId'";
$result = mysqli_fetch_array(mysqli_query($conn, $sql));

$point = $result['point'] + 1;

$sql = "update users set point = '$point' where id = '$userId'";
mysqli_query( $conn, $sql);

?>