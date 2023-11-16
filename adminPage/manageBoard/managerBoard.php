<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 관리</title>
    <style>
       body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e9ecef;
            color: #495057;
        }

        .container {
            max-width: 95%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        .table th {
            background-color: #007bff;
            color: white;
            font-weight: normal;
        }

        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tr:hover {
            background-color: #f1f1f1;
        }

        a, .button-link {
            color: #007bff;
            text-decoration: none;
            padding: 6px 12px;
            border: 1px solid #007bff;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover, .button-link:hover {
            background-color: #007bff;
            color: white;
            text-decoration: none;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

    </style>
</head>

<body> 
<div class="container">
    <h2>게시판관리</h2>
    <form action="" method="get">
        <select name="board_type">
            <option value="all">모든 게시판</option>
            <option value="nofi">공지사항</option>
            <option value="free">자유게시판</option>
            <option value="refe">자료실</option>
            <option value="qna">Q&A</option>
        </select>
        <input type="submit" value="검색" />
    </form>

    <?php
    include '../../connect.php';
    include '../check_admin.php';

    $board_type = $_GET['board_type'] ?? 'all';
    switch ($board_type) {
        case 'nofi':
            $sql = "SELECT * FROM board WHERE nofi = 1";
            break;
        case 'free':
            $sql = "SELECT * FROM board WHERE free = 1";
            break;
        case 'refe':
            $sql = "SELECT * FROM board WHERE refe = 1";
            break;
        case 'qna':
            $sql = "SELECT * FROM board WHERE qna = 1";
            break;
        default:
            $sql = "SELECT * FROM board";
            break;
    }
    $result = mysqli_query($conn, $sql);
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
    <div class="container">
        <a href='../adminpage.php'>
            이전
        </a>
    </div>
</body>

</html>