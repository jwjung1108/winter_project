<?php
session_start();
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
include '../../connect.php';


$sql = "select authority from users where id='$userId'";
$row = mysqli_fetch_array(mysqli_query($conn, $sql));
if($row['authority'] != 2){
    ?>
    <script>
        alert("지정된 사용자가 아닙니다.");
        location.href = "./list_nboard.php";
    </script>
    <?php
    exit();
}

$sql = "update board set title ='{$_POST['title']}', board='{$_POST['board']}' where number = '{$_GET['number']}'";

$result = mysqli_query($conn, $sql);

if ($result === false) {
    echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
} else {
?>
    <script>
        alert("게시글이 수정되었습니다.");
        location.href = "list_nboard.php";
    </script>
<?php
}
?>