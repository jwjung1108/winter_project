<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>유저 관리</title>
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

        @media screen and (max-width: 768px) {
            .container {
                width: 100%;
                padding: 10px;
                /* 좌우 패딩 조정 */
                margin-top: 10px;
                box-sizing: border-box;
                /* 패딩을 너비에 포함 */
            }

            .table-responsive {
                overflow-x: auto;
                /* 테이블이 화면을 초과할 경우 스크롤 가능하게 설정 */
            }

            .table th,
            .table td {
                padding: 8px;
                /* 셀의 패딩 조정 */
                font-size: 14px;
                /* 폰트 크기 줄임 */
            }

            input[type="text"],
            select,
            button {
                width: 100%;
                margin: 5px 0;
                /* 상하 마진 추가 */
            }

            button {
                padding: 10px;
                /* 버튼 패딩 조정 */
            }
        }

        body {
            margin: 0;
            /* 전역 마진 제거 */
            padding: 0;
            /* 전역 패딩 제거 */
            /* 기타 스타일 */
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
        <div class="table-responsive">
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
                            <td><a href='delete_user.php?id=<?php echo $row['id'] ?>'>삭제<a>
                            </td>
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
    </div>
    <div>
        <h3>등급조정
    </div>


    <div class="container">
        <div id="search_box">
            <form action="./change_rank.php" method="get">
                <input type="text" name="user" required="required" />

                <select name="rank">
                    <option value="Bronze">Bronze</option>
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Platinum">Platinum</option>
                    <option value="Master">Master</option>
                </select>
                <button>변경</button>
            </form>
        </div>
    </div>


    <div class="container">
        <a href='../adminpage.php'>이전</a>
    </div>
</body>

</html>