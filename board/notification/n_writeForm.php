<?php
session_start();
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

include '../../connect.php';

// 2. SQL Injection 방지를 위해 Prepared Statements 사용
$stmt = mysqli_prepare($conn, "SELECT authority FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "s", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    // 쿼리 실행 실패
    exit("쿼리 실행에 실패했습니다.");
}

$row = mysqli_fetch_array($result);

if ($row['authority'] != 2) {
    ?>
    <script>
        alert("지정된 사용자가 아닙니다.");
        location.href = "./list_nboard.php";
    </script>
    <?php
    exit();
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f8ff;
            padding: 20px;
            margin: 0;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            margin: 0 auto;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        textarea {
            resize: none;
            /* 텍스트 영역의 크기 조절 비활성화 */
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* 반응형 스타일 */
        @media (max-width: 768px) {
            form {
                max-width: 90%;
            }
        }
    </style>
</head>

<body>

    <form action="n_saveBoard.php" method="POST" enctype="multipart/form-data">
        <h2>글쓰기</h2>
        <p><input type="text" name="title" placeholder="제목 (예: 공지사항)"></p>
        <p><textarea name="board" placeholder="본문 (경고메세지)" rows="8"></textarea></p>
        <p>중요 공지사항<input type="checkbox" name="important" value="reference">
        <p>관련 파일 첨부 (옵션): <input type="file" name="file"></p>
        <p><input type="submit" value="작성"></p>
        <button onclick="goBack()">이전 페이지로</button>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </form>
</body>


</html>