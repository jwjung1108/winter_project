<?php
session_start();
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
include '../../connect.php';

if ($userId == '') {
  ?>
  <script>
    alert("로그인을 해주세요.");
    location.href = "./list_qboard.php";
  </script>
  <?php
  exit();
}

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
?>


<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
  <?php
  $number = $_GET['number'];
  ?>
  <h1>답변을 입력하세요.</h1>
  <form action='q_writeCommentProcess.php?number=<?php echo $number ?>' method="POST">
    <p><textarea name="text" cols="50" rows="10"></textarea></p>
    <p><input type="submit" value="작성"></p>
  </form>
</body>

</html>