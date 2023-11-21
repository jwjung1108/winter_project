<?php
include '../../connect.php';

session_start();

$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
if ($userId == '') {
    ?>
    <script>
        alert("로그인을 해주세요");
        location.href = "../index.php";
    </script>
    <?php
    exit();
}

// 이메일 인증
// $v_sql = "select verify from users where id = '$userId'";
// $v_check = mysqli_fetch_array(mysqli_query($conn, $v_sql));

// if($v_check['verify'] == 0){
?>
<script>
    //         alert("이메일인증을 진행해주세요");
    //         location.href = "../../index.php";
    //     </script>
<?php
//     exit();
// }

$number = $_GET['number'];

$row = mysqli_fetch_array(mysqli_query($conn, "select * from board where number= '$number'"));
$title = $row['title'];
$board = $row['board'];

$check_authority = mysqli_fetch_array(mysqli_query($conn, "SELECT authority FROM users WHERE id='$userId'"));
?>

<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <?php
    $check_user = "SELECT username FROM board WHERE username = '$userId' AND number = '$number'";
    $result = mysqli_fetch_array(mysqli_query($conn, $check_user));

    if ($userId != $result['username']) {
        if ($check_authority['authority'] != 2) {
            ?>
            <script>
                alert("접근 권한이 없습니다.");
                location.href = "list_board.php";
            </script>
            <?php
            exit();
        }
        ?>
        <form action='replaceProcess.php?number=<?php echo $number ?>' method="POST">
            <p><input type="title" name="title" value=<?php echo $title ?>></p>
            <p><textarea name="board" cols="50" rows="10"><?php echo $board ?></textarea></p>
            <p><input type="submit" value="수정"></p>
        </form>
        <?php
    } else {
        ?>
        <form action='replaceProcess.php?number=<?php echo $number ?>' method="POST">
            <p><input type="title" name="title" value=<?php echo $title ?>></p>
            <p><textarea name="board" cols="50" rows="10"><?php echo $board ?></textarea></p>
            <p><input type="submit" value="수정"></p>
        </form>
        <?php
    }
    ?>


</body>

</html>