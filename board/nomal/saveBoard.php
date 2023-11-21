<?php
session_start();
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
include '../../connect.php';


$view = 0;
$like = 0;

$title = isset($_POST['title']) ? $_POST['title'] : '';
$board = isset($_POST['board']) ? $_POST['board'] : '';

if ($title === '' || $board === '') { ?>
    <script>
    alert('제목과 본문을 모두 작성해주세요.');
    location.href = 'list_board.php';
    </script> 
<?php 
}

$fileDestination = '';

$file = $_FILES['file'];

// 파일 정보 가져오기
$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];
$fileType = $file['type'];


// 파일 저장 경로 설정  
$uploadDir = '/home/upload/list/';


// 파일 확장자 추출
$fileExtension = pathinfo($fileType, PATHINFO_EXTENSION);

// 파일 저장 이름 생성
$fileSaveName = uniqid() . '.' . $fileExtension;

// 파일을 지정된 경로로 이동
move_uploaded_file($fileTmpName, $uploadDir . $fileSaveName);
// var_dump($result);
$fileDestination = $uploadDir . $fileSaveName;

if($fileName == "")
$fileDestination = "";

// // 파일 업로드 처리
if (!move_uploaded_file($fileTmpName, $uploadDir . $fileSaveName)) {
    // 파일 업로드 성공한 경우
    $sql = "
        INSERT INTO board
        (title, board, username, views, likes, created, visible, freeboard, notification, QandA, isSecret, filepath, filename)
        VALUES ('$title', '$board', '$userId', '$view', '$like', NOW(), 1,1,0,0,0, '$fileDestination', '$fileName')
    ";

    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
    } else {
        // 글 작성시 포인트 상승
        include '../point/WriteBoPoint.php';
        ?>
        <script>
            alert("게시글이 작성되었습니다.");
            location.href = "list_board.php";
        </script>
        <?php
    }
} else {
    ?>

    <script>
        alert("파일 업로드에 실패하였습니다.");
        location.href = "list_board.php";
    </script>

<?php
}
?>