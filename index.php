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
    <link rel="stylesheet" href="./css/index_style.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.bundle.min.js"
        integrity="sha384-BOsAfwzjNJHrJ8cZidOg56tcQWfp6y72vEJ8xQ9w6Quywb24iOsW913URv1IS4GD"
        crossorigin="anonymous"></script>
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
        function goToQandABoardPage() {
            window.location.href = "/board/QandA/list_qboard.php";
        }
        function goToReferencePage() {
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
        function goToMyPage() {
            window.location.href = "/MyPage/mypage.php";
        }
    </script>
</head>

<body>

    <!--- GPT 코드 주석--->

    <nav class="navbar navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">학습 커aaaaaaaaaaa뮤니티</a>
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['userId'])) { ?>
                <span class="navbar-text mr-3">
                    <?php echo $_SESSION['userId']; ?> 님 환영합니다
                </span>
                <button class="btn btn-outline-light" onclick="logout()">로그아웃</button>
                <button class="btn btn-outline-light" onclick="goToMyPage()">마이페이지</button>
                <?php if ($_SESSION['authority'] == 'admin') { ?>
                <button class="btn btn-outline-light" onclick="goToadminPage()">관리자페이지</button>
                <?php } ?>
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
                        <p class="card-text">자유롭게 사용해라.</p>
                        <button onclick="goTocommonBoardPage()">자유게시판</button>

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
        <h2>공지사항</h2>
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
                $sql = 'SELECT * FROM board WHERE visible = 1 AND notification = 1 AND QandA = 0 ORDER BY important DESC, created DESC LIMIT 5';
                $result = mysqli_query($conn, $sql); ?>

                <?php
                $i = 1;
                while ($row = mysqli_fetch_array($result)) {
                    $boardType = '';
                    $class = '';
                    if ($row['important'] == 1) {
                        $boardType = '중요 공지사항';
                        $class = 'important';
                    } elseif ($row['important'] == 0) {
                        $boardType = '일반 공지사항';
                        $class = 'generic';
                    }
                    ?>
                    <td class='<?php echo $class; ?>'>
                        <?php echo $boardType; ?>
                    </td>
                    <td>
                        <?php echo $row['title']; ?>
                    </td>
                    <td>
                        <?php echo $row['username']; ?>
                    </td>
                    <td>
                        <?php echo $row['created']; ?>
                    </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>



</body>

</html>