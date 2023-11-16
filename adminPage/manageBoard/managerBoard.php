<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 관리</title>
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

        .table, .table th, .table td {
            border: 1px solid #ddd;
        }

        .table th, .table td {
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


    </div>
    <div>
        <a href='../adminpage.php'>
            이전
        </a>
    </div>
</body>

</html>