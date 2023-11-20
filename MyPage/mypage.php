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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>마이페이지</title>
</head>
<body>
    <h1>마이페이지에 오신 것을 환영합니다.</br>
    <h2>어서오세요 <?php echo $userId; ?>님 </br>
</body>
</html>

<?php




$sql = "select * from users where id = '$userId'";















?>