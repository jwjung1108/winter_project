<?php
include '../../connect.php';
include '../point/ReadPoint.php';
?>
<!doctype html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>게시판</title>
    <link rel="stylesheet" type="text/css" href="/BBS/css/style.css" />
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

        #commentModal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            display: none;
            /* 기본적으로 숨김 */
        }

        /* 모달 뒷배경 스타일 */
        #modalBackground {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
            /* 기본적으로 숨김 */
        }

        /* 텍스트 에어리어 스타일 */
        #commentModal textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        /* 버튼 스타일 */
        #commentModal input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        /* 반응형 디자인 적용 */
        @media (max-width: 768px) {
            /* 기존 반응형 스타일 */

            /* 모달 반응형 스타일 */
            #commentModal {
                width: 90%;
                /* 모바일에서는 너비를 줄임 */
            }
        }



        /* 기존 모달 스타일 */
        #commentModal {
            /* 기존 모달 스타일 */
            width: 50%;
            /* 데스크탑에서의 기본 너비 */
        }

        /* 모달 뒷배경 스타일 */
        #modalBackground {
            /* 기존 모달 뒷배경 스타일 */
        }

        /* 텍스트 에어리어 및 버튼 스타일 */
        #commentModal textarea,
        #commentModal input[type="submit"] {
            /* 기존 스타일 */
        }

        .btn-primary,
        a.btn-primary {
            background-color: #007bff;
            color: #fff;
            /* 링크의 기본 색상 재정의 */
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-bottom: 10px;
            font-size: 16px;
            text-decoration: none;
            /* 링크의 밑줄 제거 */
            display: inline-block;
            /* 버튼처럼 보이게 함 */
        }

        .btn-primary:hover,
        a.btn-primary:hover {
            background-color: #0056b3;
            text-decoration: none;
            /* 호버 시 밑줄 제거 */
        }
    </style>
</head>

<body>
    <?php
    $number = $_GET['number']; /* bno함수에 title값을 받아와 넣음*/
    $board = mysqli_fetch_array(mysqli_query($conn, "select * from reference where number ='" . $number . "'"));

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
            if (mysqli_query($conn, "update reference set views = '" . $view . "' where number = '" . $number . "'")) {
                $current_time = date($fomater, $current_time);
                mysqli_query($conn, "update time set access = '$current_time' where boardNumber = $number and userID = '{$_SESSION['userId']}'");
            }
        }
    } else {
        $view = $view + 1;
        $current_time = date($fomater, $current_time);
        mysqli_query($conn, "insert into time(userID,boardNumber, access) values('{$_SESSION['userId']}', $number, '$current_time')");
        mysqli_query($conn, "update reference set views = '" . $view . "' where number = '" . $number . "'");
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
            <?php echo $view; ?> 추천:
            <?php echo $board['likes']; ?>
            <div id="bo_line"></div>
        </div>
        <div id="bo_content">
            <?php echo nl2br($board['board']); ?>
        </div>
        <!-- 목록, 수정, 삭제 -->
        <div id="bo_ser">
            <ul>

                <li><a href="r_replaceBoard.php?number=<?php echo $board['number']; ?>">[수정]</a></li>
                <li><a href="r_deleteBoard.php?number=<?php echo $board['number']; ?>">[삭제]</a></li>
                <li><a href="r_boardLike.php?number=<?php echo $board['number']; ?>">[추천]</a></li>
            </ul>
        </div>
        <div>
            <?php $download = isset($board['filename']) ? $board['filename'] : '';
            if ($download === '') {
                echo "다운로드 파일이 존재하지 않습니다.";
            } else {
                echo $board['filename'] . " "; ?>
                <a href="../r_download.php?number=<?php echo $board['number']; ?>">[다운로드]</a>
                <?php
            }
            ?>
        </div>

        <!-- 댓글 -->
        <?php
        $sql = "select * from r_comment where boardNumber = '$number'";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="container">
            <h1 class="text-center">댓글</h1>
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
                                    } else {
                                        echo "삭제된 댓글입니다.";
                                    }
                                    ?>
                                </a>
                            </td>
                            <td>
                                <?php echo $row['userID']; ?>
                            </td>
                            <td>
                                <?php echo $row['created']; ?>
                            </td>
                            <td>
                                <a href="r_deleteComment.php?Number=<?php echo $row['Number'] ?>">
                                    <?php echo "삭제"; ?>
                                </a>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
            <p></p>
            <div class="text-center">
                <!-- 댓글 작성 버튼 -->
                <button class="btn-primary" onclick="openCommentModal()">댓글 작성</button>


                <!-- 댓글 작성 모달 -->
                <div id="modalBackground"></div>
                <div id="commentModal">
                    <form action='writeCommentProcess.php?number=<?php echo $number ?>' method="POST">
                        <textarea name="text"></textarea>
                        <input type="hidden" name="boardNumber" value="<?php echo $number; ?>">
                        <input type="submit" value="작성">
                    </form>
                </div>

                <script>
                    function openCommentModal() {
                        var modal = document.getElementById('commentModal');
                        var windowWidth = window.innerWidth;

                        if (windowWidth < 768) { // 모바일 화면의 경우
                            modal.style.width = "95%";
                        } else { // 데스크탑 화면의 경우
                            modal.style.width = "80%";
                        }

                        modal.style.display = 'block';
                        document.getElementById('modalBackground').style.display = 'block';
                    }

                    document.getElementById('modalBackground').onclick = function () {
                        this.style.display = 'none';
                        document.getElementById('commentModal').style.display = 'none';
                    };
                </script>
                <div class="text-center">
                    <a href="/" class="btn btn-secondary">목록으로 돌아가기</a>
                </div>
            </div>
        </div>
</body>

</html>