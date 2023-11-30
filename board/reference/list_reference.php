<?php
include '../../connect.php';

require "../check_authority.php";

$tierIcons = [
    'Bronze' => '/icon/bronze.png',
    'Silver' => '/icon/silver.png',
    'Gold' => '/icon/gold.png',
    'Platinum' => '/icon/platinum.png',
    'Master' => '/icon/master.png',
    'Default' => '', // 기본 아이콘 경로
];


// 정렬 방식 설정
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'number'; // 기본값은 순번
$sortIcon = ($sort == 'number') ? '▲' : '▼';

// 정렬 기준 설정
$orderBy = '';
switch ($sort) {
    case 'views':
        $orderBy = 'ORDER BY views';
        break;
    case 'likes':
        $orderBy = 'ORDER BY likes';
        break;
    default:
        $orderBy = 'ORDER BY number';
        break;
}

// SQL 쿼리문 수정
$sql = "SELECT reference.*, users.user_rank
        FROM reference
        JOIN users ON reference.username = users.id
        WHERE reference.visible = 1 $orderBy";

$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html lang="ko">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- script -->
    <script>
        function logout() {
            const data = confirm("로그아웃 하시겠습니까?");
            if (data) {
                location.href = "/join/logoutProcess.php";
            }
        } 
    </script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="/board/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

    <title>게시판</title>
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

        .sortable {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container-fluid">
            <!-- Navbar Brand -->
            <a class="navbar-brand" href="#">자료실</a>

            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Center-aligned links -->
                <ul class="navbar-nav mx-auto">
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
                </ul>

                <!-- Right-aligned links -->
                <ul class="navbar-nav ms-auto">
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

    <div class="container " style="margin-top: 80px;">
        <h1 class="text-center">자료실</h1>
        <div class="text-end mb-3">
            <a href="?sort=views" class="btn btn-primary <?php echo ($sort == 'views') ? 'active' : ''; ?>">조회수</a>
            <a href="?sort=likes" class="btn btn-primary <?php echo ($sort == 'likes') ? 'active' : ''; ?>">추천수</a>
            <a href="?sort=number" class="btn btn-primary <?php echo ($sort == 'number') ? 'active' : ''; ?>">순번</a>
        </div>

        <div id="search_box">
            <form action="../search_result.php" method="get">
                <select name="catgo">
                    <option value="title">제목</option>
                    <option value="username">글쓴이</option>
                    <option value="board">내용</option>
                </select>
                <input type="text" name="search" required="required" />
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
                        <th scope="col">추천수</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        $authorRank = $row['user_rank'];
                        $tierIconPath = isset($tierIcons[$authorRank]) ? $tierIcons[$authorRank] : $tierIcons['Default'];

                        // Determine color based on rank
                        switch ($authorRank) {
                            case 'Bronze':
                                $color = 'color: #cd7f32;'; // Bronze color (e.g., brown)
                                break;
                            case 'Silver':
                                $color = 'color: #c0c0c0;'; // Silver color (e.g., silver)
                                break;
                            case 'Gold':
                                $color = 'color: #ffd700;'; // Gold color (e.g., gold)
                                break;
                            case 'Platinum':
                                $color = 'color: #ff4500;'; // Platinum color (e.g., orange)
                                break;
                            case 'Master':
                                $color = 'color: #ff8c00;'; // Master color (e.g., orange)
                                break;
                            default:
                                $color = 'color: black;'; // Default color (e.g., black)
                                break;
                        }

                        ?>
                        <tr>
                            <th scope="row">
                                <?php echo $i++; ?>
                            </th>
                            <td class="title-cell"><a href="r_readBoard.php?number=<?php echo $row['number']; ?>">
                                    <?php echo $row['title']; ?>
                                </a>
                            </td>
                            <td class="title-cell" style="<?php echo $color; ?>">
                                <img src="<?php echo $tierIconPath; ?>" alt="tier" class="tier-icon" />
                                <?php echo $row['username']; ?>
                            </td>
                            <td class="title-cell">
                                <?php echo $row['created']; ?>
                            </td>
                            <td>
                                <?php echo $row['views']; ?>
                            </td>
                            <td>
                                <?php echo $row['likes']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="r_writeForm.php" class="btn btn-primary">작성</a>
            <a href="/" class="btn btn-secondary">목록으로 돌아가기</a>
        </div>
    </div>
</body>

</html>