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
.freeboard {
    color: blue;
}

.notification {
    color: red;
}

.qanda {
    color: green;
}

.reference {
    color: purple;
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
            window.location.href = "/board/nomal/list_board.php";
        }
        function goTonotificationBoardPage() {
            window.location.href = "/board/notification/list_nboard.php";
        }
        function goToQandABoardPage(){
            window.location.href = "/board/QandA/list_qboard.php";
        }
        function goToReferencePage(){
            window.location.href = "/board/reference/list_reference.php";
        }
        function logout() {
            const data = confirm("로그아웃 하시겠습니까?");
            if (data) {
                location.href = "/join/logoutProcess.php";
            }
        }
        function goToadminPage() {
            window.location.href = "/adminPage/adminpage.php";
        }
    </script>
</head>

<body>

 <!--- GPT 코드 주석--->

<nav class="navbar navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">학습  커뮤니티</a>
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
        메뉴
    </div>
    
    <!-- Features -->
    <div class="row">
        <!-- 공지 사항 -->
        <div class="col-md-3">
            <div class="card card-custom">
                <img src="/image/notice.png" alt="공지 사항">
                <div class="card-body card-body-custom ">
                    <h5 class="card-title">공지사항</h5>
                    <p class="card-text">공지사항 읽어라.</p>
                    <button onclick="goTonotificationBoardPage()">공지사항</button>
                </div>
            </div>
        </div>

        <!-- 자유 게시판 -->
        <div class="col-md-3">
            <div class="card card-custom">
                <img src="/image/tip.png" alt="자유게시판">
                <div class="card-body card-body-custom">
                    <h5 class="card-title">자유게시판</h5>
                    <p class="card-text">자유게시판 사용해라.</p>
                    <?php if (isset($_SESSION['userId'])) { ?>
                <button onclick="goTocommonBoardPage()">자유게시판</button>
            <?php } ?>
                </div>
            </div>
        </div>
        
        <!-- 자료실 -->
        <div class="col-md-3">
            <div class="card card-custom">
                <img src="/image/resource.png" alt="resouce">
                <div class="card-body card-body-custom">
                    <h5 class="card-title">자료실</h5>
                    <p class="card-text">좋은 자료가 많다.</p>
                    <button onclick="goToReferencePage()">자료실</button>
                </div>
            </div>
        </div>
        
        <!-- Q&A -->
        <div class="col-md-3">
            <div class="card card-custom">
                <img src="/image/Q&A.png" alt="Q&A">
                <div class="card-body card-body-custom">
                    <h5 class="card-title">Q&A</h5>
                    <p class="card-text">묻고 답하라.</p>
                    <button onclick="goToQandABoardPage()">QandA</button>
                </div>
            </div>
        </div>
        
        
    </div>
    
</div>

<div class="container mt-4">
        <h2>최신 게시글</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">게시판 종류</th>
                    <th scope="col">제목</th>
                    <th scope="col">작성자</th>
                    <th scope="col">등록일</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include './connect.php'; // 데이터베이스 연결 정보 포함

                // 최신 게시글 5개를 가져오는 쿼리
                $sql = 'SELECT * FROM board ORDER BY created DESC LIMIT 5';
                $result = mysqli_query($conn, $sql);?>

                <?php
                $i = 1;
                while ($row = mysqli_fetch_array($result)) {
                          $boardType = '';
                          $class = '';
                      if ($row['freeboard'] == 1) {
                          $boardType = '자유게시판';
                          $class = 'freeboard';
                       } elseif ($row['notification'] == 1) {
                           $boardType = '공지사항';
                           $class = 'notification';
                        } elseif ($row['QandA'] == 1) {
                           $boardType = 'Q&A';
                           $class = 'qanda';
                       } elseif ($row['reference'] == 1) {
                           $boardType = '자료실';
                           $class = 'reference';
                }
                ?>
                        <td class='<?php echo $class; ?>'><?php echo $boardType; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['created']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>



</body>

</html>