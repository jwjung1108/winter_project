<!DOCTYPE html>
<html lang="ko">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>학업 노하우 공유 게시판</title>
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
            position: relative;
        }

        /* "X" 버튼 스타일 */
        #close-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            z-index: 2;
            /* "X" 버튼은 이전 버튼 위에 위치하도록 z-index 조절 */
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        textarea {
            resize: none;
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
    </style>
</head>

<body>

    <form action="r_saveBoard.php" method="POST" enctype="multipart/form-data">
        <h2>학업 노하우 공유하기</h2>
        <p><input type="text" name="title" placeholder="제목 (예: 효율적인 시간 관리 방법)"></p>
        <p><textarea name="board" placeholder="본문 (학업 노하우, 공부 팁, 대외활동 경험 등을 공유해 주세요)" rows="8"></textarea></p>
        <p>관련 파일 첨부 (옵션): <input type="file" name="file"></p>
        <p><input type="submit" value="작성"></p>
    </form>

    <!-- "X" 버튼을 눌렀을 때 이전 페이지로 돌아가도록 JavaScript로 처리 -->
    <button id="close-button" onclick="goBack()">X</button>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>