<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>유저 관리</title>
    <!-- script -->
    <script>
        function chekc() {
            const data = confirm("삭제 하시겠습니까?");
            if (data) {
                location.href = "delete_user.php?id=<?php echo $row['id']; ?>";
            }
        }
    </script>


    <!-- css -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .table,
        .table th,
        .table td {
            border: 1px solid #ddd;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: left;
        }

        .table th {
            background-color: #007bff;
            color: white;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>User Management</h2>
        <?php
        include '../../connect.php';  // 데이터베이스 연결 정보 포함
        include '../check_admin.php';  // 권한 확인
        
        $sql = 'SELECT * FROM users';  // users 테이블 조회
        $result = mysqli_query($conn, $sql);
        ?>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">번호</th>
                    <th scope="col">이름</th>
                    <th scope="col">아이디</th>
                    <th scope="col">이메일</th>
                    <th scope="col">등급</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_array($result)) { ?>
                    <tr>
                        <th scope="row">
                            <?php echo $i++; ?>
                        </th>
                        <td>
                            <?php echo $row['nickname']; ?>
                        </td>
                        <td>
                            <?php echo $row['id']; ?>
                        </td>
                        <td>
                            <?php echo $row['email']; ?>
                        </td>
                        <td>
                            <?php echo $row['user_rank']; ?>
                        </td>
                        <td><button onclick="check()">삭제</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php
        if ($i == 1) {
            echo '사용자가 존재하지 않습니다.';
        }
        ?>
    </div>

    <div class="container">
        <a href='../adminpage.php'>이전</a>
    </div>
</body>

</html>