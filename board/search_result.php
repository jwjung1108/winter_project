<?php
include '../connect.php';

// 정렬 방식 설정
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'number'; // 기본값은 순번
$sortIcon = ($sort == 'number') ? '▲' : '▼';
$search_con = isset($_GET['search']) ? $_GET['search'] : '';
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

    <title>검색 결과:
        <?php echo htmlspecialchars($search_con); ?>
    </title>
    <style>
        /* 색상 및 폰트 */
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        /* 테이블 스타일링 */
        .table thead {
            background-color: #4CAF50;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* 버튼 및 폼 요소 */
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        input[type="text"] {
            padding: 5px;
            margin: 5px;
        }

        @media (max-width: 768px) {
            body {
                font-size: 16px;
            }

            .table {
                font-size: 14px;
            }

            input[type="text"],
            button {
                padding: 12px;
                font-size: 16px;
            }

            .table tbody tr:hover {
                background-color: transparent;
                /* 모바일에서는 호버 효과를 제거 */
            }

            /* 네비게이션 및 기타 요소들을 위한 추가적인 스타일링 */
        }

        /* 아이콘 사용 */
        .sort-icon {
            font-size: 12px;
            margin-left: 5px;
        }

        .back-to-list {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-to-list:hover {
            background-color: #0056b3;
        }

        /* 검색 결과 섹션 스타일링 */
        .search-results {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .search-results h1 {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container search-results">
        <h1 class="text-center">검색결과:
            <?php echo htmlspecialchars($search_con); ?>
        </h1>

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
                    $boardType = '';
                    $link = '';
                    if ($row['freeboard'] == 1) {
                        $boardType = '자유게시판';
                        $link = "board/nomal/readBoard.php?number=" . $row['number'];
                    } elseif ($row['notification'] == 1) {
                        $boardType = '공지사항';
                        $link = "board/notification/n_readBoard.php?number=" . $row['number'];
                    } elseif ($row['reference'] == 1) {
                        $boardType = '자료실';
                        $link = "board/reference/r_readBoard.php?number=" . $row['number'];
                    } elseif ($row['QandA'] == 1) {
                        $boardType = 'Q&A';
                        $link = "board/QandA/q_readBoard.php?number=" . $row['number'];
                    }
                    ?>
                    <tr>
                        <td>
                            <?php echo htmlspecialchars($boardType); ?>
                        </td>
                        <td><a href="<?php echo $link; ?>">
                                <?php echo $row['title']; ?>
                            </a>
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

    <div class="text-center">
        <a href='/' class="back-to-list">목록으로</a>
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