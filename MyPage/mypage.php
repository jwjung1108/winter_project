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

    <div class="header">
        <button onclick="goBack()" class="back-button">이전</button>
    </div>



    <div class="container">
        <h1>마이페이지에 오신 것을 환영합니다.</h1>
        <h2>어서오세요
            <?php echo $userId; ?>님
        </h2>

        <?php
        $sql = "select * from users where id = '$userId'";
        $result = mysqli_fetch_array(mysqli_query($conn, $sql));

        echo "<div class='user-info'>";
        echo "<p>아이디 : " . $result['id'] . "</p>";
        echo "<p>닉네임 : " . $result['nickname'] . "</p>";
        echo "<p>이메일 : " . $result['email'] . "</p>";
        echo "<p>랭크 : " . $result['user_rank'] . "</p>";
        echo "<p>포인트 : " . $result['point'] . "</p>";



        if ($result['user_rank'] != 'CH') {
            echo "<button onclick='requestRankUp()' class='rank-up-button'>등급 업 신청</button>";
        }

        echo "</div>";
        ?>



    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const rankUpBtn = document.querySelector('.rank-up-button');
            rankUpBtn.addEventListener('mouseover', () => {
                rankUpBtn.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
            });
            rankUpBtn.addEventListener('mouseout', () => {
                rankUpBtn.style.boxShadow = 'none';
            });
        });

        function goBack() {
            window.history.back();
        }
        function requestRankUp() {
            // 등급 업 신청 처리 로직 (예: rank_up_request.php로 요청을 보냄)
            window.location.href = 'rank_up_request.php';
        }
    </script>
</body>

</html>