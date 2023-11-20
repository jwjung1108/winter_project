<?php
include '../connect.php';
session_start();
// 로그인 검증
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>마이페이지</title>
    <link rel="stylesheet" href="../css/mypage_style.css"> 
</head>

<body>
<button onclick="goBack()" class="back-button">이전 페이지로 돌아가기</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
    <h1>마이페이지에 오신 것을 환영합니다.</h1>
    <h2>어서오세요 <?php echo $userId; ?>님 </h2>
    <?php
        $sql = "select * from users where id = '$userId'";
        $result = mysqli_fetch_array(mysqli_query($conn, $sql));

        echo "아이디 : " . $result['id'] . "<br>";
        echo "닉네임 : " . $result['nickname'] . "<br>";
        echo "이메일 : " . $result['email'] . "<br>";
        echo "랭크 : " . $result['user_rank'] . "<br>";
        echo "포인트 : " . $result['point'] . "<br>";
    ?>
</body>

</html>
