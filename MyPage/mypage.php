<?php
include '../connect.php';
session_start();
// 로그인 검증
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
if($userId == ''){
    ?>
        <script>
            alert("로그인을 해주세요");
            location.href = "../../index.php";
        </script>
    <?php
    exit();
}

echo "Hello World!";








?>