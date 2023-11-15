<?php
include '../../connect.php';

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
$search_con = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['catgo']) ? $_GET['catgo'] : '';

// 선택한 카테고리 체크박스 값 가져오기
$selectedCategories = isset($_GET['category']) ? $_GET['category'] : array();

// 카테고리를 OR 연산으로 조합
$categoryCondition = '';
if (!empty($selectedCategories)) {
    $categoryCondition = "AND (";
    foreach ($selectedCategories as $selectedCategory) {
        $categoryCondition .= "$selectedCategory = 1 OR ";
    }
    $categoryCondition = rtrim($categoryCondition, " OR ") . ")";
}

$sql = "SELECT * FROM board WHERE $category LIKE '%$search_con%' $categoryCondition AND isSecret = 0 $orderBy";
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

    <title>노하우 전수 블로그</title>
    <style>
        /* 추가한 스타일은 여기에 넣어주세요 */

        /* 반응형 디자인 */
        @media (max-width: 768px) {
            /* 스타일 추가 */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">노하우 전수 블로그</h1>

        <div id="search_box">
            <form action="./search_result.php" method="get" onsubmit="return validateForm()">
                <select name="catgo">
                    <option value="title">제목</option>
                    <option value="username">글쓴이</option>
                    <option value="board">내용</option>
                </select>
                <input type="text" name="search" size="40" required="required" />

                <label><input type="checkbox" name="category[]" value="freeboard"> 자유게시판</label>
                <label><input type="checkbox" name="category[]" value="notification"> 공지사항</label>
                <label><input type="checkbox" name="category[]" value="QandA"> Q&A</label>

                <button>검색</button>
            </form>
        </div>

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
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $i++; ?>
                        </th>
                        <td><a href="readBoard.php?number=<?php echo $row['number']; ?>"><?php echo $row['title']; ?></a>
                        </td>
                        <td>
                            <?php echo $row['username']; ?>
                        </td>
                        <td>
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
</body>

</html>
