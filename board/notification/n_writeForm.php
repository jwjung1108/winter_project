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
</head>

<body>
    <form action="n_saveBoard.php" method="POST" enctype="multipart/form-data">
        <p><input type="text" name="title" placeholder="제목"></p>
        <p><textarea name="board" placeholder="본문"></textarea></p>
        <input type="file" name="file">
        <p><input type="submit" value="작성"></p>
    </form>
</body>

</html>
