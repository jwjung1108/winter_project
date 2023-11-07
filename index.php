<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>홈페이지</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
        integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"
        integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD"
        crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            color: #000;
            /* 글자 색상을 검정으로 변경 */
        }

        h1 {
            text-align: center;
            color: #000000;
            margin-bottom: 30px;
        }

        .button-container {
            text-align: center;
            margin: 20px 0;
        }

        .button-container button {
            margin-right: 10px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            color: #fff;
            background-color: #007bff;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border-radius: 5px;
        }

        .button-container button:hover {
            background-color: #0056b3;
        }

        .welcome-container {
            text-align: right;
            margin-bottom: 20px;
        }

        .welcome-message {
            font-weight: bold;
            margin-right: 10px;
        }

        .logout-button {
            cursor: pointer;
            color: #007bff;
            text-decoration: underline;
        }

        .board-buttons {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .notification-button {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
    </style>
    <script>
        function goToLoginPage() {
            window.location.href = "/join/login.php";
        }
        function goToSignupPage() {
            window.location.href = "/join/signup.php";
        }
        function goTocommonBoardPage() {
            window.location.href = "/board/list_board.php";
        }
        function goTonotificationBoardPage() {
            window.location.href = "/board/notification/list_nboard.php";
        }
        function goToQandAPage() {
            window.location.href = "/board/QandA/list_qboard.php";
        }
        function logout() {
            const data = confirm("로그아웃 하시겠습니까?");
            if (data) {
                location.href = "/join/logoutProcess.php";
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="welcome-container">
            <?php if (isset($_SESSION['userId'])) { ?>
                <div class="welcome-message">
                    <?php echo $_SESSION['userName']; ?> 님 환영합니다
                </div>
                <span class="logout-button" onclick="logout()">로그아웃</span>
            <?php } else { ?>
                <button onclick="goToLoginPage()">로그인</button>
                <button onclick="goToSignupPage()">회원가aaaaa입</button>
            <?php } ?>
        </div>
        <h1>홈페이지</h1>
        <div class="board-buttons">
            <?php if (isset($_SESSION['userId'])) { ?>
                <button onclick="goTocommonBoardPage()">자유게시판</button>
            <?php } ?>
            <button onclick="goTonotificationBoardPage()">공지사항</button>
            <button onclick="goToQandAPage()">Q&A</button>

        </div>
    </div>
</body>

</html>