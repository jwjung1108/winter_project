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



$view = 0;
$like = 0;

$title = $_POST['title'];
$board = $_POST['board'];
$important = isset($_POST['important']) ? $_POST['important'] : 0;


$fileDestination = '';

$file = $_FILES['file'];

// 파일 정보 가져오기
$fileName = $file['name'];
$fileTmpName = $file['tmp_name'];
$fileSize = $file['size'];
$fileType = $file['type'];


// 파일 저장 경로 설정  
$uploadDir = '/home/upload/notification/';


// 파일 확장자 추출
$fileExtension = pathinfo($fileType, PATHINFO_EXTENSION);

// 파일 저장 이름 생성
$fileSaveName = uniqid() . '.' . $fileExtension;

// 파일을 지정된 경로로 이동
move_uploaded_file($fileTmpName, $uploadDir . $fileSaveName);
// var_dump($result);
$fileDestination = $uploadDir . $fileSaveName;

if ($fileName == "")
    $fileDestination = "";

// // 파일 업로드 처리
if (!move_uploaded_file($fileTmpName, $uploadDir . $fileSaveName)) {
    // 파일 업로드 성공한 경우
    $sql = "
        INSERT INTO board
        (title, board, username, views, likes, created, visible, freeboard, notification, QandA, isSecret, filepath, filename)
        VALUES ('$title', '$board', '$userId', '$view', '$like', NOW(), 1, 0, 1, 0, 0, '$fileDestination', '$fileName', '$important')
    ";

    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        echo "저장에 문제가 생겼습니다. 관리자에게 문의해주세요.";
    } else {
        ?>
        <script>
            alert("게시글이 작성되었습니다.");
            location.href = "list_nboard.php";
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