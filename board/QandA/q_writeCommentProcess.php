<?php
include '../../connect.php';
include '../point/WriteCoPoint.php';
session_start();
$sql = "select * from users where id = '$userId'";
$row = mysqli_fetch_array(mysqli_query($conn, $sql));

if ($row['authority'] != 2) {
    ?>
    <script>
        alert("권한이 없습니다.");
        location.href = "./list_qboard.php";
    </script>
    <?php
    exit();
}

$number = $_GET['number'];
$sql = "
    insert into q_comment
    (userID, boardNumber, text, created, visible)
    values('$userId','$number','{$_POST['text']}', NOW(), 1
    )";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
} else {
    ?>
    <script>
        alert("답변이 작성되었습니다.");
        location.href = "q_readBoard.php?number=<?php echo $number ?>";
    </script>
    <?php
}
?>