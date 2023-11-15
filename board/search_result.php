<!DOCTYPE html>
<html lang="ko">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <title>게시판</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
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

        h1 {
            margin-top: 30px;
        }

        #search_box {
            margin: 20px 0;
        }

        /* 모바일 친화적인 스타일 */
        @media (max-width: 768px) {
            body {
                padding-top: 20px;
            }

            .container {
                padding: 10px;
            }

            h1 {
                font-size: 24px;
            }

            .table {
                font-size: 14px;
            }

            #search_box {
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">학업 노하우 공유 게시판</h1>

        <!-- 검색 폼 -->
        <div id="search_box">
            <form action="./search_result.php" method="get" onsubmit="return validateForm()">
                <div class="mb-3">
                    <select class="form-select" name="catgo">
                        <option value="title">제목</option>
                        <option value="username">글쓴이</option>
                        <option value="board">내용</option>
                    </select>
                </div>
                <div class="mb-3">
                    <input class="form-control" type="text" name="search" placeholder="검색어" required="required" />
                </div>
                <div class="mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="category[]" value="freeboard">
                        <label class="form-check-label">자유게시판</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="category[]" value="notification">
                        <label class="form-check-label">공지사항</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="category[]" value="QandA">
                        <label class="form-check-label">Q&A</label>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">검색</button>
            </form>
        </div>

        <!-- 게시판 테이블 -->
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
