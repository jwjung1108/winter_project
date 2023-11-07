<?php
session_start();
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';

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
?>


<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <form action="./n_saveBoard.php" method="POST" enctype="multipart/form-data">
        <p><input type="title" name="title" placeholder="제목"></p>
        <p><textarea name="board" placeholder="본문"></textarea></p>
        <input type="file" name="file" >
        <p><input type="submit" value="작성"></p>
    </form>
</body>

</html>
