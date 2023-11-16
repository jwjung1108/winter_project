<?php
// mysql 연결
include '../connect.php';
session_start();

// 사용자 권한 확인
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

$sql = "SELECT authority FROM users WHERE id='$userId'";
$row = mysqli_fetch_array(mysqli_query($conn, $sql));

if ($row['authority'] != 2) {
    ?>
    <script>
        alert("접근 권한이 없습니다.");
        location.href = "/";
        
    </script>
    <?php
    exit();
}
?>

