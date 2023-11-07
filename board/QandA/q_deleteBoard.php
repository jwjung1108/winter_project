<?php
include '../../connect.php';
session_start();
?>

<?php
// 사용자 권한 확인
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

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

    $check_comment = mysqli_query($conn, "select * from q_comment where boardNumber='$number' AND visible = 1");
    $result = mysqli_num_rows($check_comment) > 0;

    if ($result) {
        ?>
        <script>
            alert("삭제가 불가능합니다.");
            location.href = "./list_qboard.php";
        </script>
        <?php
        exit();
    }

    $check_user = "SELECT username FROM board WHERE username = '$userId' AND number = '$number'";
    $result = mysqli_fetch_array(mysqli_query($conn, $check_user));

    if ($userId != $result['username']) {
        if ($row['authority'] != 2) {
            ?>
            <script>
                alert("접근 권한이 없습니다.");
                location.href = "./list_qboard.php";
            </script>
            <?php
            exit();
        }


        $sql = "UPDATE board SET visible = 0 WHERE number = '$number'";
        mysqli_query($conn, $sql);
        ?>
        <script>
            alert("게시글이 삭제되었습니다.");
            location.href = "list_qboard.php";
        </script>
        <?php
        ?>
        <?php
    } else {
        $sql = "UPDATE board SET visible = 0 WHERE number = '$number'";
        mysqli_query($conn, $sql);
        ?>
        <script>
            alert("게시글이 삭제되었습니다.");
            location.href = "list_qboard.php";
        </script>
        <?php
    }
    ?>
</body>

</html>