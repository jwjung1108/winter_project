<?php
session_start();
include '../../connect.php';

$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

// SQL 쿼리문 수정
$sql = "SELECT * FROM board WHERE visible = 1 AND notification = 0 AND QandA = 1";
$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html lang="ko">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
    <div class="container">
        <h1 class="text-center">Q&A 게시판</h1>
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

            <script>
                function validateForm() {
                    // 체크박스들을 선택
                    var checkboxes = document.querySelectorAll('input[type="checkbox"][name="category[]"]');
                    var isChecked = false;

                    // 하나라도 체크되었는지 확인
                    checkboxes.forEach(function (checkbox) {
                        if (checkbox.checked) {
                            isChecked = true;
                        }
                    });

                    // 체크가 되지 않았을 때 경고창 출력 후 검색 취소
                    if (!isChecked) {
                        alert("하나 이상의 카테고리를 선택해주세요.");
                        return false;
                    }

                    // 체크가 되었을 때 폼 제출
                    return true;
                }
            </script>

            <tbody>
                <?php
                $sql_c = "select authority from users where id='$userId'";
                $check_user = mysqli_fetch_array(mysqli_query($conn, $sql_c));
                $i = 1;
                while ($row = mysqli_fetch_array($result)) {
                    // 비밀글인 경우, authority가 2인 사용자나 작성자만 볼 수 있도록 체크
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $i++; ?>
                        </th>
                        <?php
                        if ($row['isSecret'] == 1) {
                            if ($row['username'] != $userId && $check_user['authority'] != 2) {
                                ?>
                                <td>
                                    <?php echo "비밀글입니다."; ?>
                                </td>
                                <?php
                            } else {
                                ?>
                                <td><a href="q_readBoard.php?number=<?php echo $row['number']; ?>"><?php echo $row['title']; ?></a>
                                </td>
                            <?php }
                        } else {
                            ?>
                        <td class="title-cell"><a href="q_readBoard.php?number=<?php echo $row['number']; ?>"><?php echo $row['title']; ?></a>
                        </td>
                    <?php } ?>
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
    
        <div class="text-center">
            <a href="q_writeForm.php" class="btn btn-primary">작성</a>
            <a href="/" class="btn btn-secondary">목록으로 돌아가기</a>
        </div>
    </div>
</body>

</html>