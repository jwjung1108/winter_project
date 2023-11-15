<?php
session_start();
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
include '../../connect.php';

$number = $_GET['number'];
$sql = "
    insert into comment
    (userID, boardNumber, text, created, visible)
    values('$userId','$number','{$_POST['text']}', NOW(), 1
    )";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
} else {
?>
    <script>
        alert("댓글이 작성되었습니다.");
        location.href = "readBoard.php?number=<?php echo $number?>";
    </script>
<?php
}
?>