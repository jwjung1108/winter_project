<?php
include '../../connect.php';
include '../point/ReadPoint.php';
?>

<!doctype html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>게시판</title>
    <style>
        /* 반응형 디자인 */
        @media (max-width: 768px) {

            /* 스타일 추가 */
            /* 예시: 제목 폰트 크기 줄이기 */
            h2 {
                font-size: 24px;
            }

            /* 예시: 내용 폰트 크기 줄이기 */
            #bo_content {
                font-size: 18px;
                line-height: 1.6;
            }

            /* 예시: 댓글 폰트 크기 줄이기 */
            .table td a {
                font-size: 16px;
                line-height: 1.4;
            }
        }

        /* 게시물 컨테이너 스타일 */
        #board_read {
            margin: 20px auto;
            max-width: 800px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        /* 제목 스타일 */
        h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* 작성자 및 정보 스타일 */
        #user_info {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        /* 조회수 및 추천 스타일 */
        #user_info span {
            margin-right: 10px;
        }

        /* 본문 내용 스타일 */
        #bo_content {
            font-size: 20px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        /* 목록, 수정, 삭제, 추천, 다운로드 링크 스타일 */
        #bo_ser ul {
            list-style: none;
            padding: 0;
        }

        #bo_ser li {
            display: inline;
            margin-right: 10px;
        }

        #bo_ser li a {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border-radius: 3px;
        }

        /* 댓글 컨테이너 스타일 */
        .container {
            margin-top: 20px;
            max-width: 800px;
        }

        /* 댓글 테이블 스타일 */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .table th {
            background-color: #f5f5f5;
        }

        /* 댓글 작성 링크 스타일 */
        .text-center a {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border-radius: 3px;
        }

        /* 목록으로 돌아가기 버튼 스타일 */
        .text-center .btn {
            margin-top: 10px;
        }
    </style>

</head>

<body>
    <?php
    $number = $_GET['number']; /* bno함수에 title값을 받아와 넣음*/
    $board = mysqli_fetch_array(mysqli_query($conn, "select * from board where number ='" . $number . "'"));

    $check_table = (mysqli_query($conn, "select * from time where userID='" . $_SESSION['userId'] . "' and boardNumber = '$number'"));
    $row = mysqli_fetch_array($check_table);

    $result = mysqli_num_rows($check_table) > 0;

    // 현재시간
    $current_time = time();

    // time table access 시간
    $db_access = mysqli_fetch_array(mysqli_query($conn, "select access from time where boardNumber=$number and userID='{$_SESSION['userId']}'"));

    $fomater = "Y-m-d H:i:s";
    $view = $board['views'];

    if ($result) {
        if ($current_time - strtotime($db_access['access']) > 3600) {
            $view = $view + 1;
            if (mysqli_query($conn, "update board set views = '" . $view . "' where number = '" . $number . "'")) {
                $current_time = date($fomater, $current_time);
                mysqli_query($conn, "update time set access = '$current_time' where boardNumber = $number and userID = '{$_SESSION['userId']}'");
            }
        }
    } else {
        $view = $view + 1;
        $current_time = date($fomater, $current_time);
        mysqli_query($conn, "insert into time(userID,boardNumber, access) values('{$_SESSION['userId']}', $number, '$current_time')");
        mysqli_query($conn, "update board set views = '" . $view . "' where number = '" . $number . "'");
    }
    ?>
    <!-- 글 불러오기 -->
    <div id="board_read">
        <h2>
            <?php echo $board['title']; ?>
        </h2>
        <div id="user_info">
            <?php echo $board['title']; ?>
            <?php echo $board['created']; ?> 조회:
            <?php echo $view; ?>
            <div id="bo_line"></div>
        </div>
        <div id="bo_content">
            <?php echo nl2br($board['board']); ?>
        </div>
        <!-- 목록, 수정, 삭제 -->
        <div id="bo_ser">
            <ul>
                <li><a href="q_replaceBoard.php?number=<?php echo $board['number']; ?>">[수정]</a></li>
                <numli><a href="q_deleteBoard.php?number=<?php echo $board['number']; ?>">[삭제]</a></li>
                    <li><a href="q_download.php?number=<?php echo $board['number']; ?>">[다운로드]</a></li>
            </ul>
        </div>
    

    <!-- 답변 -->
    <?php
    $sql = "select * from q_comment where boardNumber = '$number'";
    $result = mysqli_query($conn, $sql);
    ?>
    <div class="container">
        <h1 class="text-center">답변 게시판</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">번호</th>
                    <th scope="col">내용</th>
                    <th scope="col">작성자</th>
                    <th scope="col">등록일</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['visible'] == 0)
                        continue;
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $i++; ?>
                        </th>
                        <td>
                            <a>
                                <?php
                                if ($row['visible'] == 1) {
                                    echo $row['text'];
                                }
                                ?>
                            </a>

                            <!-- <a><?php echo $row['text']; ?></a> -->
                        </td>
                        <td>
                            <?php echo $row['userID']; ?>
                        </td>
                        <td>
                            <?php echo $row['created']; ?>
                        </td>
                        <td>
                            <a href="q_deleteComment.php?Number=<?php echo $row['Number'] ?>"><?php echo "삭제"; ?></a>
                        </td>
                    </tr>
                <?php } ?>

        </table>
        <p></p>
        <div class="text-center">
            <a href="q_writeComment.php?number=<?php echo $board['number']; ?>">[답변작성]</a>
            <a href="/" class="btn btn-secondary">목록으로 돌아가기</a>
        </div>


        </div>
    </div>
</body>

</html>