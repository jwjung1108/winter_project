<?php
include '../../connect.php';
?>

<?php

$sql = "SELECT authority FROM users WHERE id='$userId'";
$row = mysqli_fetch_array(mysqli_query($conn, $sql));

?>

<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <?php
    $number = $_GET['number'];
        if ($row['authority'] != 2) {
            ?>
            <script>
                alert("'접근 권한이 없습니다.';");
                location.href = "list_board.php";
            </script>
            <?php
            exit();
        }
        $sql = "UPDATE board SET visible = 0 WHERE number = '$number'";
        mysqli_query($conn, $sql);
        ?>
    <script>
        alert("게시글이 삭제되었습니다.");
        location.href = "managerBoard.php";
    </script>


</body>

</html>