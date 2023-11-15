<!DOCTYPE html>
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

        h1 {
            margin-top: 30px;
        }

        .text-end {
            margin-bottom: 20px;
        }

        #search_box {
            margin: 20px 0;
        }

        /* 추가한 스타일 */
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* 반응형 스타일 */
        @media (max-width: 768px) {
            .container {
                max-width: 90%;
            }
        }
    </style>
</head>

<body>
    <?php

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

    if ($category == 'title') {
        $catname = '제목';
    } else if ($category == 'username') {
        $catname = '작성자';
    } else if ($category == 'board') {
        $catname = '내용';
    }

    ?>
    <div class="container">
        <h1 class="text-center">게시판</h1>

        <h2>
            <?php echo $catname; ?>:
            <?php echo $search_con; ?> 검색결과
        </h2>

        <h4 style="margin-top:30px;"><a href="../index.php">홈으로</a></h4>

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
                <label><input type="checkbox" name="category[]" value="QandA"> QandA</label>

                <button>검색</button>
            </form>
        </div>
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
