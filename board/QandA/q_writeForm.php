<?php
    session_start();
    $userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
    if($userId == ''){
        ?>
        <script>
            alert("로그인을 해주세요.");
            location.href = "./list_qboard.php";

        </script>
        <?php
    }

    



?>

<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <form action="q_saveBoard.php" method="POST" enctype="multipart/form-data">
        <p><input type="title" name="title" placeholder="제목"></p>
        <p><textarea name="board" placeholder="본문"></textarea></p>
        <input type="file" name="file">
        <p><input type="checkbox" name="isSecret" value = "1"> 비밀글</p>
        <p><input type="submit" value="작성"></p>
    </form>
</body>

</html>