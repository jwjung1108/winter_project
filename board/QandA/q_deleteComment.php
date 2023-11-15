<?php
include '../../connect.php';
$number = $_GET['Number'];
$sql = "select userID from comment where Number= '$number'";
$row = mysqli_fetch_array(mysqli_query($conn, $sql));
$userid = $_SESSION['userId']
    ?>

<?php
//사용자 권한 확인
session_start();
$userId = $_SESSION['userId'];

$check_user = "select authority from users where id='$userId'";
$rows = mysqli_fetch_array(mysqli_query($conn, $check_user));

?>


<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <?php

    if ($rows['authority'] != 2) {
        ?>
        <script>
            alert("접근 권한이 없습니다.");
            location.href = "./list_qboard.php";
        </script>
        <?php
        exit();
    }
    ?>
    <?php

    $sql = "select visible from comment where number = '$number' and visible = 1";
    $row = mysqli_fetch_array(mysqli_query($conn, $sql));

    if ($row['visible'] == 1) {
        $sql = "update comment set visible = 0 where number = '$number'";
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            ?>
            <script>
                alert(""삭제에 문제가 생겼습니다.관리자에게 문의해주세요.";");
                location.href = "list_board.php";
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("댓글이 삭제되었습니다.");
                location.href = "list_board.php?=<?php ?>";
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert("이미 삭제된 댓글입니다.");
            location.href = "list_board.php?=<?php ?>";
        </script>
        <?php
    }
    ?>
</body>

</html>