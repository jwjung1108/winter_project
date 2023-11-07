<!DOCTYPE html>
<html lang="ko">

<head>
</head>

<body>
    <form action="saveBoard.php" method="POST" enctype="multipart/form-data">
        <p><input type="title" name="title" placeholder="제목"></p>
        <p><textarea name="board" placeholder="본문"></textarea></p>
        <input type="file" name="file" >
        <p><input type="submit" value="작성"></p>
    </form>
</body>

</html>
