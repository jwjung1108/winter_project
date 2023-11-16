This is admin Page test!!!!

<?php
include '../connect.php';
include '../board/check_authority.php';
?>

<!doctype html>
<html lang="ko">

<head>
<meta charset="UTF-8">
    <title>관리자 페이지</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .button-container {
            margin: 20px;
        }

        .custom-button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .custom-button:hover {
            background-color: #0056b3;
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>This is Admin Page Test!!!!</h1>
    </div>

    <div class="button-container">
        <button class="custom-button" onclick="goManagerBoardPage()">페이지 관리</button>
        <button class="custom-button" onclick="executeCommand(2)">버튼 2</button>
        <button class="custom-button" onclick="executeCommand(3)">버튼 3</button>
        <button class="custom-button" onclick="executeCommand(4)">버튼 4</button>
        <button class="custom-button" onclick="executeCommand(5)">버튼 5</button>
    </div>
    <?php
        $sql = ''    
    ?>

    <script>
        // 클릭 시 실행될 명령
        function goManagerBoardPage(){
            window.location.href = "/adminPage/manageBoard/managerBoard.php";
        }
        

        function executeCommand(buttonNumber) {
            // 여기에 버튼을 클릭했을 때 실행될 특정 명령을 넣으세요.
            // alert('버튼 ' + buttonNumber + '이(가) 클릭되었습니다.');
            // 버튼 1부터 5까지 각각 다른 명령을 실행하도록 원하시/는 작업을 여기에 추가하세요.
            // 예를 들어, switch 문을 사용하여 각 버튼별로 다른 동작을 수행하도록 구현할 수 있습니다.
            switch (buttonNumber) {
                case 1:
                    break;
                case 2:
                    // 버튼 2를 클릭했을 때 수행할 작업
                    window.location.href = "/adminPage/manageUser/managerUsers.php";
                    break;
                // 이하 버튼 3, 4, 5에 대한 작업도 추가할 수 있습니다.
                default:
                    break;
            }
        }
    </script>
    <div>
        <a href='../index.php'>이전</a>
    </div>
</body>

</html>