<?php
include '../connect.php';
session_start();

$userId = $_SESSION['userId'];

// 데이터베이스에서 사용자 정보 조회
$sql = "SELECT * FROM users WHERE id = '$userId'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_array($result);

// 포인트 확인 및 등급 업 처리
if ($user['point'] >= 1000) {
    // 등급 업 로직 (예: 사용자 등급을 업데이트하는 쿼리)
    // mysqli_query($conn, "UPDATE users SET user_rank = '새 등급' WHERE id = '$userId'");

    // 처리 후 마이페이지로 리디렉션
    header('Location: mypage.php');
} else {
    // 포인트가 충분하지 않을 경우 처리
    echo "<script>alert('포인트가 부족합니다.'); window.history.back();</script>";
}
?>
