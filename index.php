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
        .navbar-custom {
    background-color: #0056b3;
    padding: 10px 0;
    color: white;
}

.nav-link,
.navbar-brand {
    color: white;
    margin-right: 15px;
}

.nav-link:hover,
.navbar-brand:hover {
    color: #f2f2f2;
}

/* 섹션 타이틀 스타일링 */
.section-title {
    margin-top: 20px;
    margin-bottom: 10px;
    color: #333;
    text-align: left;
    font-size: 24px;
    font-weight: 600;
}

/* 카드 스타일링 */
.card-custom {
    margin: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.card-custom img {
    width: 100%;
    height: auto;
    border-top-left-radius: calc(.25rem - 1px);
    border-top-right-radius: calc(.25rem - 1px);
}

.card-body-custom {
    padding: 10px;
}

.card-title {
    margin-bottom: 10px;
    font-weight: bold;
}

.card-text {
    font-size: 14px;
    color: #666;
}

.card-link {
    font-size: 16px;
    color: #0056b3;
}

.card-link:hover {
    text-decoration: none;
    color: #003d82;
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
        function logout() {
            const data = confirm("로그아웃 하시겠습니까?");
            if (data) {
                location.href = "/join/logoutProcess.php";
            }
        }
        function goToadminPage() {
            window.location.href = "/adminpage.php";
        }
    </script>
</head>

<body>

 <!--- GPT 코드 주석--->

<nav class="navbar navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">학습  bbbbbbbbbbbbbbbbb커뮤니티</a>
        <div class="d-flex align-items-center">
            <?php if (isset($_SESSION['userId'])) { ?>
                <span class="navbar-text mr-3">
                    <?php echo $_SESSION['userId']; ?> 님 환영합니다
                </span>
                <button class="btn btn-outline-light" onclick="logout()">로그아웃</button>
                <?php if($_SESSION['authority'] == 'admin'){ ?>
                <button class="btn btn-outline-light" onclick="goToadminPage()">관리자페이지</button>
                <?php }?>
            <?php } else { ?>
                <button class="btn btn-outline-light" onclick="goToLoginPage()">로그인</button>
                <button class="btn btn-outline-light" onclick="goToSignupPage()">회원가입</button>

            <?php } ?>
        </div>
    </div>
</nav>


<!-- Main Content -->
<div class="container mt-4">

    <!-- Section Title -->
    <div class="section-title">
        주요 기능
    </div>
    
    <!-- Features -->
    <div class="row">
        <!-- 강의 평가 -->
        <div class="col-md-3">
            <div class="card card-custom">
                <img src="/image/1.webp" alt="자유게시판">
                <div class="card-body card-body-custom">
                    <h5 class="card-title">자유게시판</h5>
                    <p class="card-text">강의에 대한 리뷰와 평점을 남기고 공유할 수 있습니다.</p>
                    <?php if (isset($_SESSION['userId'])) { ?>
                <button onclick="goTocommonBoardPage()">자유게시판</button>
            <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- 과제 공유 -->
        <div class="col-md-3">
            <div class="card card-custom">
                <img src="/image/1.webp" alt="과제 공유">
                <div class="card-body card-body-custom">
                    <h5 class="card-title">과제 공유</h5>
                    <p class="card-text">과제 자료를 업로드하고 다른 사용자와 아이디어를 공유하세요.</p>
                    
                </div>
            </div>
        </div>
        
        <!-- 학습 자료실 -->
        <div class="col-md-3">
            <div class="card card-custom">
                <img src="/image/1.webp" alt="학습 자료실">
                <div class="card-body card-body-custom">
                    <h5 class="card-title">학습 자료실</h5>
                    <p class="card-text">다양한 학습 자료를 다운로드 받고, 자신만의 자료도 공유해보세요.</p>
                    
                </div>
            </div>
        </div>
        
        <!-- 토론 포럼 -->
        <div class="col-md-3">
            <div class="card card-custom">
                <img src="/image/1.webp" alt="공지 사항">
                <div class="card-body card-body-custom ">
                    <h5 class="card-title">공지사항</h5>
                    <p class="card-text">학업 관련 토론에 참여하고 지식을 공유하세요.</p>
                    <button onclick="goTonotificationBoardPage()">공지사항</button>
                </div>
            </div>
        </div>
    </div>
</div>




</body>

</html>