<!DOCTYPE html>
<html lang="ko">
<head>
</head>
<body>
    <?php
        $number = $_GET['number'];
    ?>
    <h1>댓글을 입력하세요.</h1>
  <form action='writeCommentProcess.php?number=<?php echo $number?>' method="POST">
    <p><textarea name="text" cols="50" rows="10"></textarea></p>
    <p><input type="submit" value ="작성"></p>
  </form>
</body>
</html>