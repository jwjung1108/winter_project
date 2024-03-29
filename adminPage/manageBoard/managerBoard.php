<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 관리</title>
    <style>
        /* 기본 스타일 */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e9ecef;
            color: #495057;
        }

        .container {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            /* 가운데 정렬 */
        }

        h2 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* 테이블 스타일 */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 10px;
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

        /* 버튼 스타일 */
        button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 16px;
            /* 폰트 크기 증가 */
            display: inline-block;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* 링크 스타일 */
        a,
        .button-link {
            color: #007bff;
            text-decoration: none;
            padding: 6px 12px;
            border: 1px solid #007bff;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover,
        .button-link:hover {
            background-color: #007bff;
            color: white;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
        }

        @media screen and (max-width: 768px) {

            /* 컨테이너 스타일 조정 */
            .container {
                padding: 10px;
            }

            /* 테이블이 너무 넓어 모바일 화면에 맞지 않을 때 스크롤 가능하게 설정 */
            .table-responsive {
                overflow-x: auto;
            }

            /* 모바일 환경에서 버튼 크기 조정 */
            button {
                padding: 8px 12px;
                font-size: 14px;
                /* 폰트 크기 줄임 */
            }

            /* 모바일 환경에서 테이블 셀 크기 조정 */
            .table th,
            .table td {
                padding: 8px;
            }

            .table td a {
                font-size: 14px;
                padding: 4px 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>게시판 관리</h2>
        <form action="" method="get">
            <button type="submit" name="board_type" value="all">모든 게시판</button>
            <button type="submit" name="board_type" value="notification">공지사항</button>
            <button type="submit" name="board_type" value="freeboard">자유게시판</button>
            <button type="submit" name="board_type" value="reference">자료실</button>
            <button type="submit" name="board_type" value="qanda">Q&A</button>
        </form>

        <?php
        include '../../connect.php';
        include '../check_admin.php';

        $board_type = $_GET['board_type'] ?? 'all';
        switch ($board_type) {
            case 'notification':
                $sql = "SELECT * FROM board WHERE notification = 1";
                break;
            case 'freeboard':
                $sql = "SELECT * FROM board WHERE freeboard = 1";
                break;
            case 'reference':
                $sql = "SELECT * FROM reference";
                break;
            case 'qanda':
                $sql = "SELECT * FROM board WHERE qanda = 1";
                break;
            default:
                $sql = "SELECT * FROM board";
                break;
        }
        $result = mysqli_query($conn, $sql);
        ?>


        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">제목</th>
                        <th scope="col">내용</th>
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
                                <?php echo $row['board']; ?>
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
                                    <?php echo 'X'; ?>
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
        <a class="button-link" href='../adminpage.php'>
            이전
        </a>
    </div>
</body>

</html>
