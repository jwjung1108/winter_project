<?php
session_start();

$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
if($userId == ''){
    ?>
        <script>
            alert("로그인을 해주세요");
            location.href = "../index.php";
        </script>
    <?php
    exit();
}
$v_sql = "select verify from users where id = '$userId'";
$v_check = mysqli_fetch_array(mysqli_query($conn, $v_sql));

if($v_check['verify'] == 0){
    ?>
    <script>
        alert("이메일인증을 진행해주세요");
        location.href = "../index.php";
    </script>
    <?php
    exit();
}
?>
