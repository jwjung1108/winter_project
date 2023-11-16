<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Managerboard Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #4CAF50;
            color: white;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            color: #333;
            text-decoration: none;
        }

        a:hover {
            color: #017572;
        }

        .button-link {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px 0;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .button-link:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>게시판관리</h1>
    <?php
    include '../../connect.php';
    include '../check_admin.php';

    $sql = 'select * from board';
    $result = mysqli_query($conn, $sql)
        ?>
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">번호</th>
                    <th scope="col">제목</th>
                    <th scope="col">작성자</th>
                    <th scope="col">등록일</th>
                    <th scope="col">조회수</th>
                    <th scope="col">추천수</th>
                    <th scope="col">등록</th>
                    <th scope="col">삭제</th>
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
                            <?php echo $row['title']; ?>
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
                        <td>
                            <?php echo $row['visible']; ?>
                        </td>
                        <td><a href="delete.php?number=<?php echo $row['number']; ?>">
                                <?php echo '삭제'; ?>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div>
        <?php
        if ($i == 1) {
            echo '게시글이 존재하지 않습니다.';
        }
        ?>
    </div>
    <div>
        <a href='../adminpage.php'>
            이전
        </a>
    </div>
</body>

</html>