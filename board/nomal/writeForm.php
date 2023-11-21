<!DOCTYPE html>
<html lang="ko">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자유 게시판</title>
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
            width: 95%;
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

        #back-button {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            z-index: 1;
            /* 버튼을 화면 위로 가져옵니다. */
        }
    </style>
</head>

<body>
    <form id="boardForm" action="saveBoard.php" method="POST" enctype="multipart/form-data">
        <h2>글쓰기</h2>
        <p><input type="text" name="title" id="titleInput" placeholder="제목 (예: 효율적인 시간 관리 방법)"></p>
        <p><textarea name="board" id="boardInput" placeholder="본문 (학업 노하우, 공부 팁, 대외활동 경험 등을 공유해 주세요)"
                rows="8"></textarea></p>
        <p>관련 파일 첨부 (옵션): <input type="file" name="file"></p>
        <p><input type="submit" value="작성" onclick="return validateForm()"></p>
    </form>

    <script>
        function validateForm() {
            var title = document.getElementById("titleInput").value;
            var board = document.getElementById("boardInput").value;

            if (title.trim() === '' || board.trim() === '') {
                alert("제목과 본문을 모두 작성해주세요.");
                return false; // 제출 방지
            }
            return true; // 제출 허용
        }

        document.getElementById("boardForm").addEventListener("submit", function (event) {
            if (!validateForm()) {
                event.preventDefault(); // 제출 방지
            }
        });
    </script>
    <button id="back-button" onclick="goBack()">이전 페이지로</button>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>