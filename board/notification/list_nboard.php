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
        $orderBy = 'ORDER BY views';
        break;
    default:
        $orderBy = 'ORDER BY number';
        break;
}

$sql = "SELECT * FROM board WHERE visible = 1 AND notification = 1 AND QandA = 0 $orderBy";
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
    </style>
</head>

<body>
    <div class="container">
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
                        ?>
                        <tr>
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