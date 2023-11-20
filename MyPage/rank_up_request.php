<?php
include '../connect.php';
session_start();

$userId = $_SESSION['userId'];

// 데이터베이스에서 사용자 정보 조회
$sql = "SELECT * FROM users WHERE id = '$userId'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_array($result);

// 포인트에 따른 등급 결정
$newRank = $user['user_rank'];
switch ($user['user_rank']) {
    case 'bronze':
        if ($user['point'] >= 200) $newRank = 'silver';
        break;
    case 'silver':
        if ($user['point'] >= 300) $newRank = 'gold';
        break;
    case 'gold':
        if ($user['point'] >= 400) $newRank = 'platinum';
        break;
    case 'platinum':
        if ($user['point'] >= 500) $newRank = 'master';
        break;
}

// 등급 업 로직
if ($newRank !== $user['user_rank']) {
    mysqli_query($conn, "UPDATE users SET user_rank = '$newRank' WHERE id = '$userId'");
    echo "<script>alert('등급이 업그레이드 되었습니다.'); window.location.href = 'mypage.php';</script>";
} else {
    echo "<script>alert('등급 업그레이드 조건을 충족하지 못했습니다.'); window.history.back();</script>";
}
?>
