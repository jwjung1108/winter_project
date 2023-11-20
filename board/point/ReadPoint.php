<?php
session_start();

$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
if ($userId == '') {
    ?>
    <script>
        alert("로그인을 해주세요");
        location.href = "../../index.php";
    </script>
    <?php
    exit();
}

$sql = "select point from users where id = '$userId'";
$result = mysqli_fetch_array(mysqli_query($conn, $sql));

$point = $result['point'] + 1;

$sql = "update users set point = '$point' where id = '$userId'";
mysqli_query( $conn, $sql);

?>