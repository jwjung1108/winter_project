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





