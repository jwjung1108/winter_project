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
    $check_user = "SELECT username FROM reference WHERE username = '$userId' AND number = '$number'";
    $result = mysqli_fetch_array(mysqli_query($conn, $check_user));

    if ($userId != $result['username']) {
        if ($row['authority'] != 2) {
            ?>
            <script>
                alert("'접근 권한이 없습니다.';");
                location.href = "list_reference.php";
            </script>
            <?php
            exit();
        }
        $sql = "UPDATE reference SET visible = 0 WHERE number = '$number'";
        mysqli_query($conn, $sql);
        ?>
        <script>
            alert("게시글이 삭제되었습니다.");
            location.href = "list_reference.php";
        </script>
        <?php
        ?>
        <?php
    } else {
        $sql = "UPDATE reference SET visible = 0 WHERE number = '$number'";
        mysqli_query($conn, $sql);
        ?>
        <script>
            alert("게시글이 삭제되었습니다.");
            location.href = "list_reference.php";
        </script>
        <?php
    }
    ?>
</body>

</html>