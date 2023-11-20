<?php
session_start();
include '../../connect.php';

$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

// 정렬 방식 설정
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'number'; // 기본값은 순번
$sortIcon = ($sort == 'number') ? '▲' : '▼';

// 정렬 기준 설정
$orderBy = '';
switch ($sort) {
    case 'views':
        $orderBy = 'views';
        break;
    default:
        $orderBy = 'number';
        break;
}

$sql = "SELECT * FROM board WHERE visible = 1 AND notification = 1 AND QandA = 0 ORDER BY important DESC, $orderBy desc";
$result = mysqli_query($conn, $sql);

?>

<!doctype html>
<html lang="ko">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- script -->
    <script src='../js/checkbox.js'></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="/board/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

    <title>공지사항</title>
    <style>
        body {
            padding-top: 50px;
        }

        .container {
            max-width: 960px;
        }

        .table {
            margin-bottom: 1rem;
            color: #212529;
        }

        .important {
            background-color: #00000026;
            /* 중요 공지사항 배경색 */
            color: #000;
            /* 텍스트 색상 */
            font-weight: bold;
            /* 글꼴 두껍게 */
            border: 2px solid #00000026;
            /* 테두리 스타일과 색상 */
            border-radius: 5px;
            /* 둥근 테두리 */
        }

        .generic {}
    </style>
</head>

<body>
    <!-- Navbar 시작 -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">게시판</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">홈</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/board/nomal/list_board.php">자유게시판</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/board/notification/list_nboard.php">공지사항</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/board/QandA/list_qboard.php">Q&A</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/board/reference/list_reference.php">자료실</a>
                    </li>
                    <?php if (isset($_SESSION['userId'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/MyPage/mypage.php">마이페이지</a>
                        </li>
                        <?php if ($_SESSION['authority'] == 'admin') { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/adminPage/adminpage.php">관리자페이지</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <button class="btn btn-outline-secondary" onclick="logout()">로그아웃</button>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/join/login.php">로그인</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/join/signup.php">회원가입</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container" style="margin-top: 80px;">
        <h1 class="text-center">공지사항</h1>
        <div class="text-end mb-3">
            <a href="?sort=views" class="btn btn-primary <?php echo ($sort == 'views') ? 'active' : ''; ?>">조회수</a>
            <a href="?sort=number" class="btn btn-primary <?php echo ($sort == 'number') ? 'active' : ''; ?>">순번</a>
        </div>

        <div id="search_box">
            <form action="../search_result.php" method="get" onsubmit="return validateForm()">
                <select name="catgo">
                    <option value="title">제목</option>
                    <option value="username">글쓴이</option>
                    <option value="board">내용</option>
                </select>
                <input type="text" name="search" required="required" />

                <label><input type="checkbox" name="category[]" value="freeboard"> 자유게시판</label>
                <label><input type="checkbox" name="category[]" value="notification"> 공지사항</label>
                <label><input type="checkbox" name="category[]" value="QandA"> QandA</label>

                <button>검색</button>
            </form>
        </div>



        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">제목</th>
                        <th scope="col">작성자</th>
                        <th scope="col">등록일</th>
                        <th scope="col">조회수</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        $class = '';
                        if ($row['important'] == 1) {
                            $class = 'important';
                        } elseif ($row['important'] == 0) {
                            $class = 'generic';
                        }
                        ?>
                        <tr class='<?php echo $class; ?>'>
                            <th scope="row">
                                <?php echo $i++; ?>
                            </th>
                            <td class="title-cell"><a href="n_readBoard.php?number=<?php echo $row['number']; ?>">
                                    <?php echo $row['title']; ?>
                                </a>
                            </td>
                            <td class="title-cell">
                                <?php echo $row['username']; ?>
                            </td>
                            <td class="title-cell">
                                <?php echo $row['created']; ?>
                            </td>
                            <td>
                                <?php echo $row['views']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <?php
            if ($userId != NULL) {
                $sql = "select authority from users where id='$userId'";
                $row = mysqli_fetch_array(mysqli_query($conn, $sql));
                if ($row['authority'] == 2) {
                    ?><a href="n_writeForm.php" class="btn btn-primary">작성</a>
                    <?php
                }
            }
            ?>

            <a href="/" class="btn btn-secondary">목록으로 돌아가기</a>
        </div>
    </div>
</body>

</html>