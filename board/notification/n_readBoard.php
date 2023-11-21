<?php
session_start();
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
include '../../connect.php';

$view = 0;
$like = 0;
$title = $_POST['title'];
$board = $_POST['board'];

<<<<<<< HEAD
$fileDestination = '';
$file = $_FILES['file'];
=======
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
>>>>>>> 57f5ed1964b33fd2e8f7a8ee4ca3bf0efad0a679

// 파일 정보 가져오기
$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];
$fileType = $file['type'];

// 파일 저장 경로 설정  
$uploadDir = '/home/upload/notification/';

// 파일 확장자 추출
$fileExtension = pathinfo($fileType, PATHINFO_EXTENSION);

// 파일 저장 이름 생성
$fileSaveName = uniqid() . '.' . $fileExtension;

// 파일을 지정된 경로로 이동
move_uploaded_file($fileTmpName, $uploadDir . $fileSaveName);
$fileDestination = $uploadDir . $fileSaveName;

if ($fileName == "") {
    $fileDestination = "";
}

// 파일 업로드 처리
if (!move_uploaded_file($fileTmpName, $uploadDir . $fileSaveName)) {
    // 파일 업로드 성공한 경우
    $sql = "
        INSERT INTO board
        (title, board, username, views, likes, created, visible, freeboard, notification, QandA, isSecret, filepath, filename)
        VALUES ('$title', '$board', '$userId', '$view', '$like', NOW(), 1, 0, 1, 0, 0, '$fileDestination', '$fileName')
    ";

    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
    } else {
        // 등급 업데이트
        $sqlUpdateGrade = "UPDATE users SET grade = CASE 
            WHEN grade = 'white' AND (SELECT COUNT(*) FROM board WHERE username = '$userId') >= 2 THEN 'silver'
            WHEN grade = 'silver' AND (SELECT COUNT(*) FROM board WHERE username = '$userId') >= 4 THEN 'gold'
            ELSE grade
            END
            WHERE id = '$userId'";
        mysqli_query($conn, $sqlUpdateGrade);

        // 등급에 따른 표현 추가
        $sqlSelectGrade = "SELECT grade FROM users WHERE id = '$userId'";
        $resultGrade = mysqli_query($conn, $sqlSelectGrade);
        $rowGrade = mysqli_fetch_assoc($resultGrade);
        $newGrade = $rowGrade['grade'];

        $userDisplayName = "$userId($newGrade)";

        ?>
        <script>
            alert("게시글이 작성되었습니다. 사용자 등급: <?php echo $userDisplayName; ?>");
            location.href = "./list_nboard.php";
        </script>
        <?php
    }
} else {
    ?>
<<<<<<< HEAD
    <script>
        alert("파일 업로드에 실패하였습니다.");
        location.href = "./list_board.php";
    </script>
<?php
}
?>
=======
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
                <li><a href="/">[목록으로]</a></li>
                <li><a href="n_replaceBoard.php?number=<?php echo $board['number']; ?>">[수정]</a></li>
                <li><a href="n_deleteBoard.php?number=<?php echo $board['number']; ?>">[삭제]</a></li>
            </ul>
        </div>
        <div>
            <?php $download = isset($board['filename']) ? $board['filename'] : '';
            if ($download === '') {
                echo "다운로드 파일이 존재하지 않습니다.";
            } else {
                echo $board['filename'] . " "; ?>
                <a href="../download.php?number=<?php echo $board['number']; ?>">[다운로드]</a>
                <?php
            }
            ?>
        </div>
    </div>

    <!-- 댓글 -->






    </div>
</body>

</html>
>>>>>>> 57f5ed1964b33fd2e8f7a8ee4ca3bf0efad0a679
